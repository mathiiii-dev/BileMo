<?php

namespace App\Tests;

use App\Service\PasswordCheckService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordCheckServiceTest extends TestCase
{
    private PasswordCheckService $passwordCheckService;

    protected function setUp(): void
    {
        $this->passwordCheckService = new PasswordCheckService();
    }

    public function testPagination()
    {
        $passwordCheck = $this->passwordCheckService->checkPassword('password');

        $this->assertIsBool(true, $passwordCheck);
    }

    public function testPaginationInvalid()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectDeprecationMessage('Password too short (min. 8 character)');
        $this->expectExceptionCode(400);

        $this->passwordCheckService->checkPassword('123');
    }
}
