<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product as ProductEntity;

class Product extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; ++$i) {
            $product = (new ProductEntity())
                ->setName(sprintf('Product %d', $i));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
