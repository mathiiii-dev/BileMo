<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class UserTest extends KernelTestCase
{
    public function getEntity(): User
    {
        return (new User())
            ->setUsername('UsernameTest')
            ->setEmail('test@mail.com')
            ->setPassword('password');
    }

    public function assertHasErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);
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
        $this->assertEquals('password', $this->getEntity()->getPassword());
    }

    public function testInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setUsername('a'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('a'), 1);
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    }
}
