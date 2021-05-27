<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    private $serializer;
    /**
     * @var \App\Manager\UserManager
     */
    private $userManager;
    /**
     * @var \App\Service\ValidatorService
     */
    private $validatorService;

    public function __construct(SerializerInterface $serializer, UserManager $userManager, ValidatorService $validatorService)
    {
        $this->serializer = $serializer;
        $this->userManager = $userManager;
        $this->validatorService = $validatorService;
    }

    /**
     * @Route("/sign-in", name="api_security_sign_in")
     */
    public function signIn(Request $request): Response
    {
        try {
            /** @var User $requestBody */
            $userRequest = $this->serializer->deserialize($request->getContent(), User::class, 'json');
            $user = $this->userManager->addUser($userRequest);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
        return new JsonResponse(["success" => $user->getUsername() . " a été enregistré"], 200);
    }
}
