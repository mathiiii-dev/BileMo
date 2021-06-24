<?php

namespace App\Tests;

use App\Entity\Customer;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\MakerBundle\Validator;

class CustomerTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Validator
     */
    private $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->validator = $kernel->getContainer()->get('validator');
    }

    public function assertHasError(Customer $customer, int $number = 0)
    {
        $error = $this->validator->validate($customer);
        $this->assertCount($number, $error);
    }

    public function getEntity(): Customer
    {
        $clients = $this->entityManager->getRepository(User::class)
           ->findAll();

        return (new Customer())
            ->setUsername('UsernameTest')
            ->setEmail('email@mail.com')
            ->setTelephone('0695740965')
            ->setClient($clients[0]);
    }

    public function testValidEntity()
    {
        $this->assertHasError($this->getEntity(), 0);
    }

    public function testInvalidEntity()
    {
        $this->assertHasError($this->getEntity()->setTelephone(695740965), 1);
        $this->assertHasError($this->getEntity()->setEmail('eeeeee'), 1);
        $this->assertHasError($this->getEntity()->setUsername('a'), 1);

    }
}
