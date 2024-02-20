<?php

namespace Src\Controllers\profile\oauth;

use Src\Controllers\Controller;
use Src\Security\OAuthAuthenticator;
use Src\Security\SocialProviderFactory;

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