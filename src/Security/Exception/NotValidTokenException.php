<?php

namespace App\Security\Exception;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NotValidTokenException extends AccessDeniedHttpException
{
    public function __construct(string $message = 'This request need a valid token')
    {
        parent::__construct($message);
    }
}