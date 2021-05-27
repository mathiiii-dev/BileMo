<?php

namespace App\Manager;

use App\Entity\User;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{

    /**
     * @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var \App\Service\ValidatorService
     */
    private $validatorService;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorService $validatorService)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->validatorService = $validatorService;
    }

    /**
     * @throws \Exception
     */
    public function addUser($userRequest)
    {
        $user = new User();
        $user->setUsername($userRequest->getUsername());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $userRequest->getPassword()));

        $this->checkPassword($userRequest->getPassword());
        $this->validatorService->validator($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function checkPassword(string $password)
    {
        if(strlen($password) < 8) {
            throw new \Exception("Mot de passe trop court (8 caractères min.)");
        }
    }
}
