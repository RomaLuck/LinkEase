<?php

namespace Http\Controllers\oauth;

use Core\Container;
use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;
use Http\Controllers\Controller;

class ConnectActionController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Container $container): void
    {
        $providerName = $_GET['auth'];
        $provider = SocialProviderFactory::getProvider($providerName);
        $container->set('provider', $provider);
        $authenticator = $container->get(OAuthAuthenticator::class);
        $authenticator->start();
    }
}