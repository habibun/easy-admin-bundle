<?php

namespace App\DataFixtures;

use App\Entity\Location as LocationEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Location extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; ++$i) {
            $location = (new LocationEntity())
            ->setName(sprintf('Location %d', $i));
            $manager->persist($location);
            $this->addReference(sprintf('location#%d', $i), $location);
        }

        $manager->flush();
    }
}
