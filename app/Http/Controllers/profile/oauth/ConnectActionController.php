<?php

namespace Http\Controllers\profile\oauth;

use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;
use Http\Controllers\Controller;

class ConnectActionController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(OAuthAuthenticator $authenticator): void
    {
        $provider = SocialProviderFactory::getProvider($_GET['auth']);
        $authenticator->setProvider($provider);
        $authenticator->start();
    }
}