<?php

namespace App\User;

use App\Entity\User;
use App\Service\ValidatorService;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private ValidatorService $validatorService;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ValidatorService $validatorService)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->validatorService = $validatorService;
    }

    public function createUser($userRequest): User
    {
        $user = new User();
        $user->setUsername($userRequest->getUsername());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $userRequest->getPassword()));
        $user->setEmail($userRequest->getEmail());

        return $user;
    }
}
