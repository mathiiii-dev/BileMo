<?php

namespace App\Customer;

use App\Entity\Customer;
use App\Manager\UserManager;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerFactory
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @throws \Exception
     */
    public function createCustomer(Customer $customerRequest, UserInterface $user): Customer
    {
        $customer = new Customer();

        $customer->setUsername($customerRequest->getUsername());
        $customer->setEmail($customerRequest->getEmail());
        $customer->setTelephone($customerRequest->getTelephone());
        $customer->setPassword($customerRequest->getPassword());
        $customer->setClient($this->userManager->getUserByUsername($user->getUsername()));

        return $customer;
    }
}
