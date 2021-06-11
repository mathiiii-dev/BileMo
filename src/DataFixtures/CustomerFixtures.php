<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserRepository $userRepository;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = new Factory();


        $clients = $this->userRepository->findAll();

        for ($i = 0; $i < 20; $i++) {

            $client = array_rand($clients);
            $customer = new Customer();
            $customer->setPassword("password")
                ->setEmail($faker::create()->email)
                ->setUsername($faker::create()->userName)
                ->setTelephone($faker::create()->randomNumber(9))
                ->setClient($clients[$client]);
            $manager->persist($customer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
