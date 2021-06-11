<?php

namespace App\Customer;

use App\Entity\Customer;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerHandler
{
    private CustomerFactory $customerFactory;
    private ValidatorService $validator;
    private EntityManagerInterface $entityManager;

    public function __construct(CustomerFactory $customerFactory, ValidatorService $validator, EntityManagerInterface $entityManager)
    {
        $this->customerFactory = $customerFactory;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function createCustomerHandler($customerRequest, UserInterface $user): Customer
    {
        $customer = $this->customerFactory->createCustomer($customerRequest, $user);
        $this->validator->validator($customer);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function deleteCustomerHandler(Customer $customer)
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}
