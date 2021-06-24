<?php

namespace App\Controller;

use App\Handler\CustomerHandler;
use App\Manager\CustomerManager;
use App\Service\CacheService;
use OpenApi\Annotations as OA;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerController extends AbstractController
{
    private SerializerInterface $serializer;
    private CustomerHandler $customerHandler;
    private CustomerManager $customerManager;
    private NormalizerInterface $normalizer;
    private CacheService $cacheService;

    public function __construct(
        SerializerInterface $serializer,
        CustomerManager $customerManager,
        NormalizerInterface $normalizer,
        CustomerHandler $customerHandler,
        CacheService $cacheService
    ) {
        $this->serializer = $serializer;
        $this->customerHandler = $customerHandler;
        $this->customerManager = $customerManager;
        $this->normalizer = $normalizer;
        $this->cacheService = $cacheService;
    }

    /**
     * @Route("/customer/add", name="add_customer", methods={"POST"})
     * @OA\Post(
     *     path="/customer/add",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/customerAdd"),
     *     @OA\Response(
     *      response="200",
     *      description="Create a customer",
     *      @OA\JsonContent(example="Customer1 has been registered")
     * )
     * )
     *
     * @throws \Exception
     */
    public function add(Request $request): JsonResponse
    {
        $customer = $this->customerHandler->createCustomerHandler($request, $this->getUser());

        return new JsonResponse(['success' => $customer->getUsername().' has been registered'], 200);
    }

    /**
     * @Route("/customer/delete/{id}", name="delete_customer", methods={"DELETE"}, requirements={"id"="\d+"})
     * @OA\Delete (
     *     path="/customer/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="The id of the customer",
     *      required=true
     *     ),
     *     @OA\Schema(ref="#/components/parameters/id"),
     *     @OA\Response(
     *      response="200",
     *      description="Delete a customer",
     *     @OA\JsonContent(example="The customer has been deleted")
     * ),
     * @OA\Response(
     *      response="404",
     *      description="Customer not found",
     *     @OA\JsonContent(example="The customer hasn't been found")
     * ),
     * @OA\Response(
     *      response="500",
     *      description="Customer owner right",
     *     @OA\JsonContent(example="You can't delete this customer")
     * ),
     * )
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
     * @Route("/customer/{id}", name="get_customer", methods={"GET"}, requirements={"id"="\d+"})
     * @OA\Get(
     *     path="/customer/{id}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="The id of the customer",
     *      required=true,
     *     ),
     *     @OA\Schema(ref="#/components/parameters/id"),
     *     @OA\Response(
     *      response="200",
     *      description="Customer detail",
     *     @OA\JsonContent(ref="#/components/schemas/Customer")
     * ),
     *     @OA\Response(
     *      response="404",
     *      description="Customer not found",
     *     @OA\JsonContent(example="The customer hasn't been found")
     * )
     * )
     *
     * @throws ExceptionInterface
     */
    public function getOne(int $id): Response
    {
        return $this->cacheService->cache($this->json($this->normalizer->normalize($this->customerManager->getCustomerById($id), null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            'groups' => 'customer',
        ])));
    }

    /**
     * @Route("/customers", name="get_customers", methods={"GET"})
     * @OA\Get(
     *     path="/customers",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="The id of the client",
     *      required=true
     *     ),
     *     @OA\Schema(ref="#/components/parameters/id"),
     *     @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="The index of the page",
     *      required=true
     *     ),
     *     @OA\Schema(type="integer"),
     *     @OA\Response(
     *      response="200",
     *      description="Product detail",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Customer"))
     * ),
     *     @OA\Response(
     *      response="404",
     *      description="Customer not found",
     *     @OA\JsonContent(example="The client hasn't been found")
     * ),
     * )
     *
     * @throws ExceptionInterface
     */
    public function getAll(Request $request): Response
    {
        $id = $request->get('id');
        $page = $request->get('page');

        return $this->cacheService->cache($this->json($this->normalizer->normalize($this->customerManager->getAllCustomerByClient($id, $page), null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            'groups' => 'customer',
        ])));
    }
}
