<?php

namespace App\Controller;

use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/product/{id}", name="api_get_product", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function product(int $id): JsonResponse
    {
        return $this->json($this->productManager->getProduct($id), 200, [], ['groups' => 'show_detail_product']);
    }

    /**
     * @Route("/products", name="api_get_products", methods={"GET"})
     */
    public function products(Request $request): JsonResponse
    {
        $page = $request->get('page');

        return $this->json($this->productManager->getProducts($page), 200, [], ['groups' => 'show_list_products']);
    }
}
