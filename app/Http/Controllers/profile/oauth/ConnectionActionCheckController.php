<?php

namespace Http\Controllers\profile\oauth;

use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;
use Http\Controllers\Controller;

class ConnectionActionCheckController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(OAuthAuthenticator $authenticator): void
    {
        $provider = SocialProviderFactory::getProvider();
        $authenticator->setProvider($provider);
        $authenticator->authenticate();
    }
}