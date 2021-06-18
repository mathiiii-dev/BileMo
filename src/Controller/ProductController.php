<?php

namespace App\Controller;

use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private ProductManager $productManager;

    public function __construct(ProductRepository $productRepository, ProductManager $productManager)
    {
        $this->productRepository = $productRepository;
        $this->productManager = $productManager;
    }

    /**
     * @Route("/product/{id}", name="get_product", methods={"GET"}, requirements={"id"="\d+"})
     * @OA\Get(
     *     path="/product/{id}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="The id of the product",
     *      required=true
     *     ),
     *     @OA\Schema(ref="#/components/parameters/id"),
     *     @OA\Response(
     *      response="200",
     *      description="Product detail",
     *     @OA\JsonContent(ref="#/components/schemas/Product")
     * ),
     *     @OA\Response(
     *      response="404",
     *      description="Product not found",
     *     @OA\JsonContent(example="The product hasn't been found")
     * ),
     * )
     */
    public function product(int $id): JsonResponse
    {
        return $this->json($this->productManager->getProduct($id), 200, [], ['groups' => 'show_detail_product']);
    }

    /**
     * @Route("/products", name="get_products", methods={"GET"})
     * @OA\Get(
     *     path="/products",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="The page index",
     *      required=true
     *     ),
     *     @OA\Schema(type="integer"),
     *     @OA\Response(
     *      response="200",
     *      description="Products list",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     * ),
     *     @OA\Response(
     *      response="404",
     *      description="Products not found",
     *     @OA\JsonContent(example="No products have been found")
     * ),
     * )
     */
    public function products(Request $request): JsonResponse
    {
        $page = $request->get('page');

        return $this->json($this->productManager->getProducts($page), 200, [], ['groups' => 'show_list_products']);
    }
}
