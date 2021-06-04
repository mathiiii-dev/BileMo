<?php

namespace App\Manager;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerManager
{
    private EntityManagerInterface $entityManager;
    private UserManager $userManager;
    private ValidatorService $validatorService;
    private CustomerRepository $customerRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserManager $userManager,
        ValidatorService $validatorService,
        CustomerRepository $customerRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->validatorService = $validatorService;
        $this->customerRepository = $customerRepository;
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

    /**
     * @throws \Exception
     */
    public function deleteCustomer(int $id, UserInterface $user)
    {
        $customer = $this->getCustomerById($id);
        $this->checkClientForCustomer($customer, $user);
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }

    public function getCustomerById(int $id): Customer
    {
        $customer = $this->customerRepository->findOneBy(["id" => $id]);

        if (!$customer) {
            throw new NotFoundHttpException("The customer hasn't been found");
        }

        return $customer;
    }

    /**
     * @throws \Exception
     */
    public function checkClientForCustomer(Customer $customer, UserInterface $user)
    {
        if ($customer->getClient()->getId() !== $this->userManager->getUserByUsername($user->getUsername())->getId()) {
            throw new \Exception("You can't delete this customer");
        }
    }

    public function getAllCustomerByClient(int $id): array
    {
        $this->userManager->getUserById($id);
        return $this->customerRepository->findBy(["client" => $id]);
    }
}
