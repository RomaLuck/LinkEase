<?php

namespace Http\Controllers\oauth;

use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;
use Http\Controllers\Controller;

class ConnectActionController extends Controller
{
    public function __invoke(): void
    {
        $providerName = $_GET['auth'];
        $provider = SocialProviderFactory::getProvider($providerName);
        $authenticator = new OAuthAuthenticator($provider);
        $authenticator->start();
    }
}