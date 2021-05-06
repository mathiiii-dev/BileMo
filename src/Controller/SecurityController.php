<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{

    private ClientRegistry $clientRegistry;
    private Serializer $serializer;
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ClientRegistry $clientRegistry,
        SerializerInterface $serializer,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    )
    {
        $this->clientRegistry = $clientRegistry;
        $this->serializer = $serializer;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/connect/{service}", name="api_connect")
     */
    public function connect(string $service): RedirectResponse
    {
        /** @var GithubClient $client */
        $client = $this->clientRegistry->getClient($service);
        return $client->redirect(['read:user', 'user:email']);
    }

    /**
     * @Route("/access_token/{service}", name="api_access_token")
     */
    public function accessToken(Request $request, string $service): JsonResponse
    {
        $client = $this->clientRegistry->getClient($service);
        try {
            $accesstoken = $client->getAccessToken();
            $request->getSession()->set('access_token', $accesstoken);
                return new JsonResponse($accesstoken, 200);
        } catch (IdentityProviderException $e) {
            return new JsonResponse(["Error" => [
                "Message" => $e->getMessage(),
                "Code" => $e->getCode()
                ]
            ]);
        }
    }

    /**
     * @Route("/sign-in", name="api_sign_in", methods={"POST"})
     */
    public function signIn(Request $request): JsonResponse
    {
        try {
            /** @var User $requestBody */
            $requestBody = $this->serializer->deserialize($request->getContent(), User::class, 'json');

            $user = new User();
            $user->setEmail($requestBody->getEmail());
            $user->setUsername($requestBody->getUsername());

            $password = $requestBody->getPassword();
            $hashPassword = $this->passwordEncoder->encodePassword($user, $password);
            $user->setPassword($hashPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(["Message" => $e->getMessage()]);

        }
        return new JsonResponse(["Message" => "User added"]);
    }

    /**
     * @Route("/secured", name="api_secured")
     */
    public function secured(Request $request): JsonResponse
    {
        dd($request->headers->get('Authorization'), $request->getSession()->get('access_token') );
        return new JsonResponse(["Secured" => true]);
    }
}
