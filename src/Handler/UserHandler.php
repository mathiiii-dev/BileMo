<?php

namespace App\Handler;

use App\Entity\User;
use App\Service\PasswordCheckService;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserHandler
{
    private ValidatorService $validator;
    private EntityManagerInterface $entityManager;
    private PasswordCheckService $passwordCheck;
    private SerializerInterface $serializer;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        ValidatorService $validator,
        EntityManagerInterface $entityManager,
        PasswordCheckService $passwordCheck,
        SerializerInterface $serializer,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->passwordCheck = $passwordCheck;
        $this->serializer = $serializer;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @throws \Exception
     */
    public function handleCreate(Request $request): User
    {
        /** @var User $requestBody */
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $this->passwordCheck->checkPassword($user->getPassword());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $this->validator->validator($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
