<?php

namespace Src\Security;

use Doctrine\ORM\EntityManager;
use Exception;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\GoogleUser;
use Src\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class OAuthAuthenticator
{
    private AbstractProvider $provider;

    public function __construct(
        private EntityManager $entityManager,
        private Authenticator $authenticator,
        private Session       $session
    )
    {
    }

    public function setProvider(AbstractProvider $provider): void
    {
        $this->provider = $provider;
    }

    public function getProvider(): AbstractProvider
    {
        return $this->provider;
    }

    public function start(): void
    {
        if (empty($_GET['code'])) {
            $authUrl = $this->provider->getAuthorizationUrl();
            $this->session->set('oauth2state', $this->provider->getState());
            header('Location: ' . $authUrl);
        }
    }

    public function authenticate(): void
    {
        if (!empty($_GET['error'])) {
            exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
        }

        if (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state'))) {
            $this->session->remove('oauth2state');
            exit('Invalid state');
        }

        try {
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            /** @var GoogleUser $ownerDetails */
            $ownerDetails = $this->provider->getResourceOwner($token);

            $email = $ownerDetails->getEmail();
            $username = $ownerDetails->getName();
            $oauthId = $ownerDetails->getId();

            $user = $this->entityManager->getRepository(User::class)->findOneBy([
                'email' => $email,
                'oauth_id ' => $oauthId,
            ]) ?? new User();

            $user->setName($username)
                ->setEmail($email)
                ->setPassword(password_hash($oauthId, PASSWORD_BCRYPT))
                ->setOauthId($oauthId);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->authenticator->login($user);

            header('Location: ./');
        } catch (Exception $e) {
            exit('Something went wrong: ' . $e->getMessage());
        }
    }
}