<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;
    private ValidatorService $validatorService;
    private UserRepository $userRepository;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        ValidatorService $validatorService,
        UserRepository $userRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->validatorService = $validatorService;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function checkPassword(string $password)
    {
        if(strlen($password) < 8) {
            throw new \Exception("Password too short (min. 8 character)", 403);
        }
    }

    public function getUserByUsername(string $username): ?User
    {
        $user = $this->userRepository->findOneBy(["username" => $username]);

        if(!$user) {
            throw new NotFoundHttpException("The client haven't been found");
        }

        return $user;
    }

    public function getUserById(int $id): ?User
    {
        $user = $this->userRepository->findOneBy(["id" => $id]);

        if(!$user) {
            throw new NotFoundHttpException("The client haven't been found");
        }

        return $user;
    }
}
