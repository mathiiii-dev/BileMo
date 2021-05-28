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
            throw new NotFoundHttpException("Le produit n'a pas été trouvé");
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
            throw new NotFoundHttpException("Plus aucun produit n'a été trouvé");
        }

        return $products;
    }

}
