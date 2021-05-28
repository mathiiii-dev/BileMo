<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws \Exception
     */
    public function validator($object)
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new \Exception($errors[0]->getMessage(), 401);
        }
    }
}
