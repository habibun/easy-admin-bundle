<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order as OrderEntity;

class Order extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; ++$i) {
            $location = $this->getReference(sprintf('location#%d', $i));
            $order = (new OrderEntity())
                ->setDate(new \DateTime())
                ->setLocation($location)
                ->setTotalPrice(sprintf('%d00', $i));
            $manager->persist($order);
        }

        $manager->flush();
    }
}
