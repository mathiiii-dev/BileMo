<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = new Factory();
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setPassword($this->passwordEncoder->encodePassword($user, "password"))
                ->setEmail($faker::create()->email)
                ->setUsername($faker::create()->userName);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
