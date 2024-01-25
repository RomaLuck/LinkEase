<?php

namespace Http\Controllers\oauth;

use Core\Container;
use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;
use Http\Controllers\Controller;
use League\OAuth2\Client\Provider\AbstractProvider;

class ConnectionActionCheckController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Container $container): void
    {
        $provider = SocialProviderFactory::getProvider();
        /** @var OAuthAuthenticator $authenticator */
        $authenticator = $container->get(OAuthAuthenticator::class);
        $authenticator->setProvider($provider);
        $authenticator->authenticate();
    }
}