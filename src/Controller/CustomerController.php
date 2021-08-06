<?php

namespace App\Controller;

use App\Handler\CustomerHandler;
use App\Manager\CustomerManager;
use App\Service\CacheService;
use App\Service\RequestParametersCheckService;
use App\Service\ResponseService;
use Exception;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private CustomerHandler $customerHandler;
    private CustomerManager $customerManager;
    private CacheService $cacheService;
    private ResponseService $response;
    private RequestParametersCheckService $paramsCheckService;

    public function __construct(
        CustomerManager $customerManager,
        CustomerHandler $customerHandler,
        CacheService $cacheService,
        ResponseService $response,
        RequestParametersCheckService $paramsCheckService
    ) {
        $this->customerHandler = $customerHandler;
        $this->customerManager = $customerManager;
        $this->cacheService = $cacheService;
        $this->response = $response;
        $this->paramsCheckService = $paramsCheckService;
    }

    /**
     * @Route("/customers", name="add_customer", methods={"POST"})
     * @OA\Post(
     *     path="/customers/add",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/customerAdd"),
     *     @OA\Response(
     *      response="201",
     *      description="Create a customer",
     *      @OA\JsonContent(example="Customer1 has been registered")
     * )
     * )
     *
     * @throws Exception
     */
    public function add(Request $request): JsonResponse
    {
        $customer = $this->customerHandler->handleCreate($request, $this->getUser());

        return new JsonResponse(['success' => $customer->getUsername().' has been registered. With id '.$customer->getId()], 201);
    }

    /**
     * @Route("/customers/{id}", name="delete_customer", methods={"DELETE"}, requirements={"id"="\d+"})
     * @OA\Delete (
     *     path="/customers/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="The id of the customer",
     *      required=true
     *     ),
     *     @OA\Schema(ref="#/components/parameters/id"),
     *     @OA\Response(
     *      response="204",
     *      description="Delete a customer",
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
     * @throws Exception
     */
    public function delete(int $id): JsonResponse
    {
        $customer = $this->customerManager->getCustomerById($id);
        $this->denyAccessUnlessGranted('owner', $customer);
        $this->customerHandler->handleDelete($customer);

        return new JsonResponse(null, 204);
    }

    /**
     * @Route("/customers/{id}", name="get_customer", methods={"GET"}, requirements={"id"="\d+"})
     * @OA\Get(
     *     path="/customers/{id}",
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
     */
    public function getOne(int $id): Response
    {
        return $this->cacheService->cache(
            $this->response->setUpResponse($this->customerManager->getCustomerById($id), 'customer')
        );
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
     * @throws Exception
     */
    public function getAll(Request $request): Response
    {
        $params = $this->paramsCheckService->checkParamsCustomers($request);

        return $this->cacheService->cache(
            $this->response->setUpResponse($this->customerManager->getAllCustomerByClient($params['id'], $params['page']), 'customers')
        );
    }
}
