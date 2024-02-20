<?php

namespace Src\Controllers\profile\oauth;

use Src\Controllers\Controller;
use Src\Security\OAuthAuthenticator;
use Src\Security\SocialProviderFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class ConnectionActionCheckController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(OAuthAuthenticator $authenticator, Session $session): void
    {
        $provider = SocialProviderFactory::getProvider($session);
        $authenticator->setProvider($provider);
        $authenticator->authenticate();
    }
}