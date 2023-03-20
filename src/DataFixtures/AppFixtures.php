<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createCategory($manager);
        $this->createProduct($manager);

        $manager->flush();
    }

    public function createCategory(ObjectManager $manager)
    {
        // Create 10 category
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $manager->persist($category);

            $this->addReference('category_' . $i, $category);
        }

        $manager->flush();
    }

    public function createProduct(ObjectManager $manager)
    {
        // Create 10 product
        for ($i=0; $i < 10; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setDescription('Description ' . $i);
            $product->setCode('Code ' . $i);
            $product->setCreatedAt(new \DateTime());
            $product->setStatus(true);
            $product->setCategory($this->getReference('category_' . $i));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
