<?php

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductManager
{
    private ProductRepository $productRepository;
    private PaginationService $pagination;
    private EntityManagerInterface $entityManager;

    public function __construct(ProductRepository $productRepository, PaginationService $pagination, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->pagination = $pagination;
        $this->entityManager = $entityManager;
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);

        if (null === $product) {
            throw new NotFoundHttpException('The product n°'.$id." hasn't been found", null, 404);
        }

        return $product;
    }

    public function getProducts(int $page): array
    {
        $count = $this->entityManager->createQueryBuilder()->select('count(product.id)')->from('App:Product', 'product');
        $pagination = $this->pagination->getPagination($page, $count->getQuery()->getSingleScalarResult());
        $products = $this->productRepository->findBy([], [], $pagination['limit'], $pagination['offset']);

        if (empty($products)) {
            throw new NotFoundHttpException('No products have been found');
        }

        array_push($products, ['_embedded' => ['pages' => $pagination['pages']]]);

        if ($pagination['currentPage'] <= 0 || $pagination['currentPage'] > $pagination['pages'] || !filter_var($page, FILTER_VALIDATE_INT)) {
            throw new BadRequestHttpException('This page doesn\'t exist. (only '.$pagination['pages'].' pages)', null, 400);
        }

        return $products;
    }
}
