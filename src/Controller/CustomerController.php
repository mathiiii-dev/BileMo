<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Manager\CustomerManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerController extends AbstractController
{
    private SerializerInterface $serializer;
    private CustomerManager $customerManager;

    public function __construct(SerializerInterface $serializer, CustomerManager $customerManager)
    {
        $this->serializer = $serializer;
        $this->customerManager = $customerManager;
    }

    /**
     * @Route("/add-customer", name="add_customer", methods={"POST"})
     * @throws \Exception
     */
    public function add(Request $request): JsonResponse
    {
        /** @var \App\Entity\Customer $requestBody */
        $customerRequest = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');
        $customer = $this->customerManager->addCustomer($customerRequest, $this->getUser());

        return new JsonResponse(["success" => $customer->getUsername() . " a été enregistré"], 200);
    }
}
