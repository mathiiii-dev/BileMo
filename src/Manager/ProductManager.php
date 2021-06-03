<?php

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductManager
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->findOneBy(["id" => $id]);

        if ($product === null) {
            throw new NotFoundHttpException("The product n°".$id." hasn't been found");
        }

        return $product;
    }

    public function getProducts(int $page, int $offset): array
    {
        $products = [];

        foreach ($this->productRepository->findBy([], [], 10, $offset) as $product) {
            $products[] = [
                "product" => $product
            ];
        }

        if (empty($products)) {
            throw new NotFoundHttpException("No products have been found", null, 404);
        }

        return $products;
    }

}
