<?php

namespace Core\Security;

use Core\Session;
use InvalidArgumentException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;

class SocialProviderFactory
{
    public static function getProvider(?string $providerName = null): AbstractProvider
    {
        $oauthConfig = new OAuthConfig;

        if (!Session::has('provider')) {
            if ($providerName !== null && $oauthConfig->getProviderConfig($providerName)) {
                Session::put('provider', $providerName);
            } else {
                throw new InvalidArgumentException('Provider not set in session');
            }
        }

        return match (Session::get('provider')) {
            'google' => new Google($oauthConfig->getProviderConfig('google')),
            default => throw new InvalidArgumentException('Invalid provider name'),
        };
    }
}