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
        // admin user
        $user = (new UserEntity())
        ->setEmail('admin@localhost.com')
        ->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $manager->persist($user);

        // normal user
        $user = (new UserEntity())
            ->setEmail('user@localhost.com')
            ->setRoles(['ROLE_USER']);

        $password = $this->hasher->hashPassword($user, 'user');
        $user->setPassword($password);
        $manager->persist($user);

        // moderator user
        $user = (new UserEntity())
            ->setEmail('moderator@localhost.com')
            ->setRoles(['ROLE_MODERATOR']);

        $password = $this->hasher->hashPassword($user, 'moderator');
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
    }
}
