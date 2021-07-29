<?php

namespace App\Manager;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\PaginationService;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function getCustomerById(int $id): Customer
    {
        $customer = $this->customerRepository->findOneBy(['id' => $id]);

        if (!$customer) {
            throw new NotFoundHttpException('The customer n° '.$id." hasn't been found");
        }

        return $customer;
    }

    public function getAllCustomerByClient(int $id, int $page): array
    {
        $count = $this->entityManager->createQueryBuilder()->select('count(customer.id)')->from('App:Customer', 'customer')->where('customer.client = '.$id);
        $this->userManager->getUserById($id);
        $pagination = $this->pagination->getPagination($page, $count->getQuery()->getSingleScalarResult());
        $customers = $this->customerRepository->findBy(['client' => $id], [], $pagination['limit'], $pagination['offset']);
        array_push($customers, ['_embedded' => ['pages' => $pagination['pages']]]);

        if (empty($customers)) {
            throw new NotFoundHttpException('No customers have been found', null, 404);
        }

        return $customers;
    }
}
