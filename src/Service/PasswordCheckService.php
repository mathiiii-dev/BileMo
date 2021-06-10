<?php

namespace App\Service;

class PasswordCheckService
{
    /**
     * @throws \Exception
     */
    public function checkPassword(string $password)
    {
        if(strlen($password) < 8) {
            throw new \Exception("Password too short (min. 8 character)", 403);
        }
    }
}
