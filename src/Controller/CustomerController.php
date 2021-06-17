<?php

namespace App\Controller;

use App\Customer\CustomerHandler;
use App\Entity\Customer;
use App\Manager\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerController extends AbstractController
{
    private SerializerInterface $serializer;
    private CustomerHandler $customerHandler;
    private CustomerManager $customerManager;
    /**
     * @var \Symfony\Component\Serializer\Normalizer\NormalizerInterface
     */
    private NormalizerInterface $normalizer;

    public function __construct(
        SerializerInterface $serializer,
        CustomerManager $customerManager,
        NormalizerInterface $normalizer
    ) {
        $this->serializer = $serializer;
        $this->customerHandler = $customerHandler;
        $this->customerManager = $customerManager;
        $this->normalizer = $normalizer;
    }

    /**
     * @Route("/customer/add", name="add_customer", methods={"POST"})
     *
     * @throws \Exception
     */
    public function add(Request $request): JsonResponse
    {
        /** @var \App\Entity\Customer $requestBody */
        $customerRequest = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');
        $customer = $this->customerHandler->createCustomerHandler($customerRequest, $this->getUser());

        return new JsonResponse(['success' => $customer->getUsername().' has been registered'], 200);
    }

    /**
     * @Route("/customer/delete/{id}", name="delete_customer", methods={"DELETE"})
     *
     * @throws \Exception
     */
    public function delete(int $id): JsonResponse
    {
        $customer = $this->customerManager->getCustomerById($id);
        $this->denyAccessUnlessGranted('owner', $customer);
        $this->customerHandler->deleteCustomerHandler($customer);

        return new JsonResponse(['success' => 'The customer has been deleted'], 200);
    }

    /**
     * @Route("/customer/{id}", name="get_customer", methods={"GET"})
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getOne(int $id): JsonResponse
    {
        return $this->json($this->normalizer->normalize($this->customerManager->getCustomerById($id), null, [
            'circular_reference_handler' => function($object) {
                return $object->getId();
            }
        ]));
    }

    /**
     * @Route("/customers", name="get_customers", methods={"GET"})
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getAll(Request $request): JsonResponse
    {
        $id = $request->get("id");
        $page = $request->get("page");

        return $this->json($this->normalizer->normalize($this->customerManager->getAllCustomerByClient($id, $page), null, [
            'circular_reference_handler' => function($object) {
                return $object->getId();
            }
        ]));
    }
}
