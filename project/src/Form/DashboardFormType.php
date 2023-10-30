<?php

namespace App\Form;

use App\Entity\Dashboard;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DashboardFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'tinymce',
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('authorizedUsers', EntityType::class, [
                'class' => User::class,
                'label' => 'Personnes autorisées',
                'query_builder' => function (EntityRepository $u): QueryBuilder {
                    return $u->createQueryBuilder('u')
                        ->orderBy('u.lastname', 'ASC')
                    ;
                },
                'choice_label' => function (User $user): string {
                    return $user->getLastname().' '.$user->getFirstname();
                },
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dashboard::class,
        ]);
    }
}