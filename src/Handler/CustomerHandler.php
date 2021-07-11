<?php

namespace App\Handler;

use App\Entity\Customer;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerHandler
{
    private ValidatorService $validator;
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(
        ValidatorService $validator,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @throws Exception
     */
    public function handleCreate(Request $request, UserInterface $user): Customer
    {
        /** @var Customer $requestBody */
        $customer = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');
        $customer->setClient($user);
        $this->validator->validator($customer);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function handleDelete(Customer $customer): void
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}
