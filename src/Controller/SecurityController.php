<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Service\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    private SerializerInterface $serializer;
    private UserManager $userManager;
    private ValidatorService $validatorService;

    public function __construct(
        SerializerInterface $serializer,
        UserManager $userManager,
        ValidatorService $validatorService
    ) {
        $this->serializer = $serializer;
        $this->userManager = $userManager;
        $this->validatorService = $validatorService;
    }

    /**
     * @Route("/sign-in", name="api_security_sign_in", methods={"POST"})
     * @throws \Exception
     */
    public function signIn(Request $request): Response
    {
        /** @var User $requestBody */
        $userRequest = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user = $this->userManager->addUser($userRequest);

        return new JsonResponse(["success" => $user->getUsername() . " a été enregistré"], 200);
    }
}
