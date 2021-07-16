<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordCheckService
{
    /**
     * @throws Exception
     */
    public function checkPassword(string $password): bool
    {
        if (strlen($password) < 8) {
            throw new BadRequestHttpException('Password too short (min. 8 character)');
        }

        return true;
    }
}
