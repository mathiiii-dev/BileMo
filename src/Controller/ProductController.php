<?php

namespace App\Controller;

use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use App\Service\CacheService;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private ProductManager $productManager;
    private CacheService $cacheService;

    public function __construct(ProductRepository $productRepository, ProductManager $productManager, CacheService $cacheService)
    {
        $this->productRepository = $productRepository;
        $this->productManager = $productManager;
        $this->cacheService = $cacheService;
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
    public function product(int $id): Response
    {
        return $this->cacheService->cache(
            $this->json($this->productManager->getProduct($id), 200, [], ['groups' => 'show_detail_product'])
        );
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
    public function products(Request $request): Response
    {
        $page = $request->get('page');

        return $this->cacheService->cache($this->json($this->productManager->getProducts($page), 200, [], ['groups' => 'show_list_products']));
    }
}
