<?php

namespace Src\Http\Profile\Oauth;

use Src\Http\Controller;
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