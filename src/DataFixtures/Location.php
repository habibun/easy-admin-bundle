<?php

namespace App\DataFixtures;

use App\Entity\Location as LocationEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Location extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; ++$i) {
            $location = (new LocationEntity())
            ->setName(sprintf('Location %d', $i))
                ->setEnabled($faker->boolean())
            ;

            $manager->persist($location);
            $this->addReference(sprintf('location#%d', $i), $location);
        }

        $manager->flush();
    }
}
