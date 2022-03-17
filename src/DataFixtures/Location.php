<?php

namespace App\DataFixtures;

use App\Entity\Location as LocationEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Location extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $adminUser = $this->getReference(sprintf('%s#%d', User::class, 1));

        $faker = Factory::create();

        for ($i = 1; $i <= 10; ++$i) {
            $location = (new LocationEntity())
            ->setName(sprintf('Location %d', $i))
                ->setEnabled($faker->boolean())
                ->setDescription($faker->sentence())
                ->setUpdatedBy($adminUser)
            ;

            $manager->persist($location);
            $this->addReference(sprintf('location#%d', $i), $location);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return [
          User::class,
        ];
    }
}
