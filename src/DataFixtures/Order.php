<?php

namespace App\DataFixtures;

use App\Entity\Order as OrderEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Order extends Fixture implements DependentFixtureInterface
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

    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return [
            Location::class,
        ];
    }
}
