<?php

namespace App\Controller;

use App\Entity\Dashboard;
use App\Entity\User;
use App\Form\DashboardFormType;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    #[Route('/dashboard/list/{user}', 'dashboard_list')]
    public function list(?User $user)
    {
        $dashboards = $user->getDashboardsAuthorized();

        return $this->render('dashboard/list.html.twig', [
            'dashboards' => $dashboards,
        ]);
    }

    #[Route('/dashboard/show/{id}', 'dashboard_show')]
    public function show(?Dashboard $dashboard): Response
    {
        return $this->render('dashboard/show.html.twig', [
            'dashboard' => $dashboard,
        ]);
    }

    #[Route('/dashboard/new', 'dashboard_new')]
    public function new(
        Request $request,
        Security $security,
        UserRepository $userRepository,
        EntityManagerInterface $em,
    ): Response {
        $dashboard = new Dashboard();

        $form = $this->createForm(DashboardFormType::class, $dashboard);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $userRepository->findOneBy(['id' => $security->getUser()->getId()]);

            $dashboard = $form->getData();
            $dashboard->setCreatedAt(new DateTimeImmutable('now'));
            $dashboard->setUpdatedAt(new DateTime('now'));
            $dashboard->setCreatedBy($user);
            $dashboard->addAuthorizedUser($user);

            $em->persist($dashboard);
            $em->flush();

            return $this->redirectToRoute('dashboard_list', [
                'user' => $user->getId(),
            ]);
        }

        return $this->render('dashboard/new.html.twig', [
            'form' => $form,
            'step' => 'new',
        ]);
    }

    #[Route('/dashboard/edit/{id}', name: 'dashboard_edit')]
    public function edit(
        ?Dashboard $dashboard,
        Request $request,
        Security $security,
        UserRepository $userRepository,
        EntityManagerInterface $em,
    ) {
        $user = $userRepository->findOneBy(['id' => $security->getUser()->getId()]);

        if ($dashboard->getCreatedBy() != $user) {
            return $this->redirectToRoute('dashboard_list', [
                'user' => $user->getId()
            ]);
        }

        $form = $this->createForm(DashboardFormType::class, $dashboard);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $dashboard = $form->getData();

            $em->persist($dashboard);
            $em->flush();

            return $this->redirectToRoute('dashboard_list', [
                'user' => $user->getId(),
            ]);
        }

        return $this->render('dashboard/new.html.twig', [
            'form' => $form,
            'step' => 'edit',
            'dashboard' => $dashboard,
        ]);
    }
}