<?php

namespace App\Controller;

use App\Handler\UserHandler;
use App\Service\ValidatorService;
use Exception;
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
     * @throws Exception
     */
    public function signIn(Request $request): Response
    {
        $user = $this->userHandler->handleCreate($request);

        return new JsonResponse(['success' => $user->getUsername().' has been registered'], 200);
    }

    /**
     * @Route("/login_check", name="security_login", methods={"POST"})
     * @OA\Post(
     *     path="/login_check",
     *     @OA\RequestBody(ref="#/components/requestBodies/login"),
     *     @OA\Response(
     *      response="200",
     *      description="Login",
     *      @OA\JsonContent(example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MjQwMjIwMTEsImV4cCI6MTYyNDAyMjkxMSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoieHphdmllcjA4In0.Ur_Oij3ilkTzAqsZFqRXrD5wxZgfoAfvK0NY4kqNc5Ca0OUDh7GTZZ7zoqxV6QUe9lbPTCVO9BVLpxb_iQcOA_uJq5-zyeIYmdrTi60ZiVCZ0rP1RWAraPxfv0vNidp7roplHvOxy9ujTJ1DtLJfXM7t8avxfDBznJmcdn0wQOxet201SiHzyHIlmT8_dMHtsR1XpLg3Dxl35xpMAkoSqDzxKLCrVnY8w9Qsv--WDQ9uG8S5hZoKEbkADjnQXFLWQAOdPEGrTLQqlqjScvM12Opdth5JIjaLP9MIJcxB8JiRh8gZYKcsV0kFe3uu-XPIfxQqDw6Yv20J473X5HPpfw")
     * )
     * )
     */
    public function login(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
}
