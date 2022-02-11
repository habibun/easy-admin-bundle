<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@localhost.com');
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        for ($i = 1; $i <= 10; ++$i) {
            $product = new Product();
            $product->setName(sprintf('product-%d', $i));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
