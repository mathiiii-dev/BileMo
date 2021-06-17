<?php

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\PaginationService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductManager
{
    private ProductRepository $productRepository;
    private PaginationService $pagination;

    public function __construct(ProductRepository $productRepository, PaginationService $pagination)
    {
        $this->productRepository = $productRepository;
        $this->pagination = $pagination;
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->findOneBy(["id" => $id]);

        if ($product === null) {
            throw new NotFoundHttpException("The product n°".$id." hasn't been found");
        }

        return $product;
    }

    public function getProducts(int $page): array
    {
        $pagination = $this->pagination->getPagination($page);
        $products = $this->productRepository->findBy([], [], $pagination["limit"], $pagination["offset"]);

        if (empty($products)) {
            throw new NotFoundHttpException("No products have been found", null, 404);
        }

        return $products;
    }

}
