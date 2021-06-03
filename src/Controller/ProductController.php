<?php

namespace App\Controller;

use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/product/{id}", name="api_get_product", methods={"GET"})
     */
    public function product(int $id): JsonResponse
    {
        return $this->json(["product" => $this->productManager->getProduct($id)], 200);
    }

    /**
     * @Route("/products/{page}", name="api_get_products", methods={"GET"})
     */
    public function products(?int $page): JsonResponse
    {
        $currentPage = $page ?? 1;
        $perPage = 10;
        $offset = $perPage * ($currentPage - 1);

        return $this->json(["products" => $this->productManager->getProducts($page, $offset)], 200);
    }
}
