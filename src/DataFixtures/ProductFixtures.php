<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $faker = new Factory();
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setProduct($faker::create()->name)
                ->setReference($faker::create()->isbn10)
                ->setColor($faker::create()->safeColorName)
                ->setBrand($faker::create()->company)
                ->setPrice($faker::create()->randomFloat(2, 200, 1300))
                ->setStock($faker::create()->numberBetween(0, 9000))
                ->setDescription($faker::create()->realText(200, 2))
                ->setReleaseDate($faker::create()->dateTimeThisDecade);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
