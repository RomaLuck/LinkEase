<?php

namespace Src\Http\Profile\Oauth;

use Src\Http\Controller;
use Src\Security\OAuthAuthenticator;
use Src\Security\SocialProviderFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class ConnectActionController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(OAuthAuthenticator $authenticator, Session $session): void
    {
        $provider = SocialProviderFactory::getProvider($session, $_GET['auth']);
        $authenticator->setProvider($provider);
        $authenticator->start();
    }
}