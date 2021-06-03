<?php


namespace App\Manager;


use App\Entity\Customer;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerManager
{
    private EntityManagerInterface $entityManager;
    private UserManager $userManager;
    private ValidatorService $validatorService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserManager $userManager,
        ValidatorService $validatorService
    )
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->validatorService = $validatorService;
    }

    /**
     * @throws \Exception
     */
    public function addCustomer(Customer $customerRequest, UserInterface $user): Customer
    {
        $customer = new Customer();
        $customer->setUsername($customerRequest->getUsername());
        $customer->setEmail($customerRequest->getEmail());
        $customer->setTelephone($customerRequest->getTelephone());
        $customer->setPassword($customerRequest->getPassword());
        $customer->setClient($this->userManager->getUserByUsername($user->getUsername()));

        $this->validatorService->validator($customer);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}