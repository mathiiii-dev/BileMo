<?php

namespace App\Tests;

use App\Service\PasswordCheckService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordCheckServiceTest extends KernelTestCase
{
    public function testPagination()
    {
        self::bootKernel();
        /** @var PasswordCheckService $pagination */
        $pagination = self::$container->get(PasswordCheckService::class);

        $this->assertIsBool(true, $pagination->checkPassword('password'));
    }
}
