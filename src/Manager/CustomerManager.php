<?php

namespace App\Manager;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\PaginationService;
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
    private PaginationService $pagination;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserManager $userManager,
        ValidatorService $validatorService,
        CustomerRepository $customerRepository,
        PaginationService $pagination
    ) {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->validatorService = $validatorService;
        $this->customerRepository = $customerRepository;
        $this->pagination = $pagination;
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
        if ($customer->getClient() !== $this->userManager->getUserByUsername($user->getUsername())->getId()) {
            throw new \Exception("You can't delete this customer");
        }
    }

    public function getAllCustomerByClient(int $id, int $page): array
    {
        $this->userManager->getUserById($id);
        $pagination = $this->pagination->getPagination($page);
        $customers = $this->customerRepository->findBy(["client" => $id], [], $pagination["limit"], $pagination["offset"]);

        if (empty($customers)) {
            throw new NotFoundHttpException("No customers have been found", null, 404);
        }

        return $customers;
    }
}
