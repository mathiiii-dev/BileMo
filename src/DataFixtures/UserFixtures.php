<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $usersInfo = [
            [
                'username' => 'Mathias',
                'email' => 'mathias@mail.com',
            ],
            [
                'username' => 'John',
                'email' => 'john@mail.com',
            ],
            [
                'username' => 'David',
                'email' => 'david@mail.com',
            ],
            [
                'username' => 'Paul',
                'email' => 'paul@mail.com',
            ],
        ];

        foreach ($usersInfo as $userInfo) {
            $user = new User();
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
                ->setEmail($userInfo['email'])
                ->setUsername($userInfo['username']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
