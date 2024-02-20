<?php

namespace Src\Controllers\profile\oauth;

use Src\Controllers\Controller;
use Src\Security\OAuthAuthenticator;
use Src\Security\SocialProviderFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class ConnectActionController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(OAuthAuthenticator $authenticator, Session $session): void
    {
        $provider = SocialProviderFactory::getProvider($session, $_GET['auth']);
        $authenticator->setProvider($provider);
        $authenticator->start();
    }
}