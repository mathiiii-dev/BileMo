<?php


namespace App\User;


use App\Manager\UserManager;
use App\Service\PasswordCheckService;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class UserHandler
{
    private UserFactory $userFactory;
    private UserManager $userManager;
    private ValidatorService $validator;
    private EntityManagerInterface $entityManager;
    private PasswordCheckService $passwordCheck;

    public function __construct(
        UserFactory $userFactory,
        ValidatorService $validator,
        EntityManagerInterface $entityManager,
        PasswordCheckService $passwordCheck
    ) {
        $this->userFactory = $userFactory;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->passwordCheck = $passwordCheck;
    }

    /**
     * @throws \Exception
     */
    public function handle($userRequest): \App\Entity\User
    {
        $user = $this->userFactory->createUser($userRequest);

        $this->passwordCheck->checkPassword($userRequest->getPassword());
        $this->validator->validator($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}