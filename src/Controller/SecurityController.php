<?php

namespace App\Controller;

use App\Handler\UserHandler;
use App\Service\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;

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
     * @Route("/sign-in", name="security_sign_in", methods={"POST"})
     * @OA\Post(
     *     path="/sign-in",
     *     @OA\RequestBody(ref="#/components/requestBodies/signin"),
     *     @OA\Response(
     *      response="200",
     *      description="Create a client",
     *      @OA\JsonContent(example="Client1 has been registered")
     * )
     * )
     *
     * @throws \Exception
     */
    public function signIn(Request $request): Response
    {
        $user = $this->userHandler->createUserHandler($request);

        return new JsonResponse(['success' => $user->getUsername().' has been registered'], 200);
    }
}
