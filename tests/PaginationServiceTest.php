<?php

namespace App\Tests;

use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaginationServiceTest extends KernelTestCase
{
    public function testPagination()
    {
        self::bootKernel();
        $pagination = self::$container->get(PaginationService::class)->getPagination(1, 14);

        $this->assertCount(2, $pagination);
    }
}
