<?php

namespace Src\Security;

use Src\Database;
use Exception;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Session\Session;

class OAuthAuthenticator
{
    private AbstractProvider $provider;

    public function __construct(
        private Database      $database,
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

            $user = $this->database->query('SELECT * FROM users WHERE email = :email AND oauth_id = :oauthId', [
                'email' => $email,
                'oauthId' => $oauthId,
            ])->fetch();

            if ($user) {
                $this->authenticator->login($user);

                header('Location: ./');
            }

            $this->database->query('INSERT INTO users(username, email, password, oauth_id) VALUES(:username, :email, :password, :oauth_id)', [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($oauthId, PASSWORD_BCRYPT),
                'oauth_id' => $oauthId,
            ]);

            $this->authenticator->login($user);

            header('Location: ./');
        } catch (Exception $e) {
            exit('Something went wrong: ' . $e->getMessage());
        }
    }
}