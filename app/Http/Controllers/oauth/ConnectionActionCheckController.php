<?php

namespace Http\Controllers\oauth;

use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;
use Http\Controllers\Controller;

class ConnectionActionCheckController extends Controller
{
    public function __invoke(): void
    {
        $provider = SocialProviderFactory::getProvider();
        $authenticator = new OAuthAuthenticator($provider);
        $authenticator->authenticate();
    }
}