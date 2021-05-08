<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Security\Exception\NotVerifiedEmailException;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubAuthenticator extends SocialAuthenticator
{
    private ClientRegistry $clientRegistry;
    private UserRepository $userRepository;

    public function __construct (ClientRegistry $clientRegistry, UserRepository $userRepository)
    {
        $this->clientRegistry = $clientRegistry;
        $this->userRepository = $userRepository;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new Response('Auth header required', 401);
    }

    public function supports(Request $request): bool
    {
        return 'oauth_check' === $request->attributes->get('_route') && $request->get('service') === 'github';
    }

    public function getCredentials(Request $request)
    {
        return $request->getSession()->get('access_token');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $githubUser = $this->getClient()->fetchUserFromToken($credentials);

        // On récupère l'email de l'utilisateur (spécifique à github)
        $response = HttpClient::create()->request(
            'GET',
            'https://api.github.com/user/emails',
            [
                'headers' => [
                    'authorization' => "token {$credentials->getToken()}"
                ]
            ]
        );
        $emails = json_decode($response->getContent(), true);
        foreach($emails as $email) {
            if ($email['primary'] === true && $email['verified'] === true) {
                $data = $githubUser->toArray();
                $data['email'] = $email['email'];
                $githubUser = new GithubResourceOwner($data);
            }
        }

        if ($githubUser->getEmail() === null) {
            throw new NotVerifiedEmailException();
        }

        return $this->userRepository->findOrCreateFromGithubOauth($githubUser, $credentials);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        return new Response('Auth failed : ' . $exception->getMessage(), $exception->getCode());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return null;
    }

    private function getClient(): OAuth2ClientInterface
    {
        return $this->clientRegistry->getClient('github');
    }
}
