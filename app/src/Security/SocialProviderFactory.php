<?php

namespace Src\Security;

use InvalidArgumentException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;
use Symfony\Component\HttpFoundation\Session\Session;

class SocialProviderFactory
{
    public static function getProvider(Session $session, ?string $providerName = null): AbstractProvider
    {
        $oauthConfig = new OAuthConfig;

        if (!$session->has('provider')) {
            if ($providerName !== null && $oauthConfig->getProviderConfig($providerName)) {
                $session->set('provider', $providerName);
            } else {
                throw new InvalidArgumentException('Provider not set in session');
            }
        }

        return match ($session->get('provider')) {
            'google' => new Google($oauthConfig->getProviderConfig('google')),
            default => throw new InvalidArgumentException('Invalid provider name'),
        };
    }
}