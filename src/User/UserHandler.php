<?php


namespace App\User;


use App\Manager\UserManager;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class UserHandler
{
    private UserFactory $userFactory;
    private UserManager $userManager;
    private ValidatorService $validator;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserFactory $userFactory,
        UserManager $userManager,
        ValidatorService $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function handle($userRequest) {
        $user = $this->userFactory->createUser($userRequest);

        $this->userManager->checkPassword($userRequest->getPassword());
        $this->validator->validator($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}