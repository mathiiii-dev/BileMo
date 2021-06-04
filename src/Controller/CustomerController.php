<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Manager\CustomerManager;
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
     * @Route("/customer/add", name="add_customer", methods={"POST"})
     * @throws \Exception
     */
    public function add(Request $request): JsonResponse
    {
        /** @var \App\Entity\Customer $requestBody */
        $customerRequest = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');
        $customer = $this->customerManager->addCustomer($customerRequest, $this->getUser());

        return new JsonResponse(["success" => $customer->getUsername() . " has been registered"], 200);
    }

    /**
     * @Route("/customer/delete/{id}", name="delete_customer", methods={"DELETE"})
     * @throws \Exception
     */
    public function delete(int $id): JsonResponse
    {
        $this->customerManager->deleteCustomer($id, $this->getUser());

        return new JsonResponse(["success" => "The customer has been deleted"], 200);
    }

    /**
     * @Route("/customer/{id}", name="get_customer", methods={"GET"})
     */
    public function getOne(int $id): JsonResponse
    {
        return $this->json($this->customerManager->getCustomerById($id));
    }

    /**
     * @Route("/customers", name="get_customers", methods={"GET"})
     */
    public function getAll(Request $request): JsonResponse
    {
        $id = $request->get("id");
        $page = $request->get("page");
        return $this->json($this->customerManager->getAllCustomerByClient($id, $page));
    }
}
