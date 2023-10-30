<?php

namespace App\DataFixtures;

use App\Entity\CategoryType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoriesType = ['incomes', 'expenses', 'savings'];

        foreach ($categoriesType as $ct) {
            $categoryType = new CategoryType();
            
            $categoryType->setName($ct);
            $manager->persist($categoryType);
        }

        $manager->flush();
    }
}