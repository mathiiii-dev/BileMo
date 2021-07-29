<?php

namespace App\Tests;

use App\Service\PaginationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaginationServiceTest extends TestCase
{
    private PaginationService $paginationService;

    protected function setUp(): void
    {
        $this->paginationService = new PaginationService();
    }

    public function testPagination()
    {
        $pagination = $this->paginationService->getPagination(1, 14);

        $this->assertCount(3, $pagination);
    }

    public function testPaginationInvalid()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectDeprecationMessage('This page doesn\'t exist. (only 2 pages)');
        $this->expectExceptionCode(400);

        $this->paginationService->getPagination(3, 14);
    }
}
