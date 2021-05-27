<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validator($object)
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new \Exception($errors[0]->getMessage());
        }
        return true;
    }
}
