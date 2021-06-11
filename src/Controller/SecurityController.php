<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ValidatorService;
use App\User\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorService $validatorService;
    private UserHandler $userHandler;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorService $validatorService,
        UserHandler $userHandler
    ) {
        $this->serializer = $serializer;
        $this->validatorService = $validatorService;
        $this->userHandler = $userHandler;
    }

    /**
     * @Route("/sign-in", name="api_security_sign_in", methods={"POST"})
     *
     * @throws \Exception
     */
    public function signIn(Request $request): Response
    {
        /** @var User $requestBody */
        $userRequest = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user = $this->userHandler->handle($userRequest);

        return new JsonResponse(['success' => $user->getUsername().' has been registered'], 200);
    }
}
