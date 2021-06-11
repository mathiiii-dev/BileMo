<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @var \KnpU\OAuth2ClientBundle\Client\ClientRegistry
     */
    private ClientRegistry $clientRegistry;

    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
    }

    /**
     * @Route("/connect/github", name="github_connect")
     */
    public function connect(): RedirectResponse
    {
        /** @var GithubClient $client */
        $client = $this->clientRegistry->getClient('github');
        return $client->redirect(['read:user', 'user:email']);
    }

    /**
     * @Route("/access_token", name="access_token")
     */
    public function accessToken(\Symfony\Component\HttpFoundation\Request $request): JsonResponse
    {
        /** @var GithubClient $client */
        $client = $this->clientRegistry->getClient('github');
        try {
            $accesstoken = $client->getAccessToken();
            $request->getSession()->set('access_token', $accesstoken);
            return new JsonResponse([
                "access_token" => $accesstoken->getToken()
            ], 200);
        } catch (IdentityProviderException $e) {
            return new JsonResponse(["Error" => [
                "Message" => $e->getMessage(),
                "Code" => $e->getCode()
                ]
            ]);
        }
    }
}
