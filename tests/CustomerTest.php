<?php

namespace App\Tests;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class CustomerTest extends KernelTestCase
{
    public function getEntity(): Customer
    {
        return (new Customer())
            ->setUsername('UsernameTest')
            ->setEmail('test@mail.com')
            ->setTelephone('0695740965');
    }

    public function assertHasErrors(Customer $customer, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($customer);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
        $this->assertEquals('UsernameTest', $this->getEntity()->getUserName());
        $this->assertEquals('test@mail.com', $this->getEntity()->getEmail());
        $this->assertEquals('0695740965', $this->getEntity()->getTelephone());
    }

    public function testInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setUsername('a'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('a'), 2);
        $this->assertHasErrors($this->getEntity()->setTelephone(695740965), 1);
    }
}
