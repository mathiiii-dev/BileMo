<?php

namespace App\Tests;

use App\Entity\Product;
use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class ProductManagerTest extends TestCase
{
    private $productManager;
    private $productRepository;
    private $product;

    protected function setUp(): void
    {
        $this->product = new Product();
        $this->productRepository = $this->createMock(ProductRepository::class);
        $pagination = $this->createMock(PaginationService::class);
        $em = $this->createMock(EntityManager::class);
        $this->productManager = new ProductManager($this->productRepository, $pagination, $em);
    }

    public function testValidGetProduct()
    {
        $this->productRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 64])
            ->willReturn($this->product);

        $this->productManager->getProduct(64);

    }

}
