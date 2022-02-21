<?php

namespace App\DataFixtures;

use App\Entity\User as UserEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class User extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new UserEntity())
        ->setEmail('admin@localhost.com')
        ->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $manager->persist($user);

        for ($i = 1; $i <= 10; ++$i) {
            $user = (new UserEntity())
                ->setEmail(sprintf('user%d@localhost.com', $i))
                ->setRoles(['ROLE_USER']);

            $password = $this->hasher->hashPassword($user, sprintf('user%d', $i));
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
