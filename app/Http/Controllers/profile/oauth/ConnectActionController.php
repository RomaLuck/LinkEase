<?php

namespace Http\Controllers\profile\oauth;

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
        $provider = SocialProviderFactory::getProvider($_GET['auth']);
        /** @var OAuthAuthenticator $authenticator */
        $authenticator = $container->get(OAuthAuthenticator::class);
        $authenticator->setProvider($provider);
        $authenticator->start();
    }
}