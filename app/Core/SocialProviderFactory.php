<?php

namespace Core;

use InvalidArgumentException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;

class SocialProviderFactory
{
    public static function getProvider(?string $providerName = null): AbstractProvider
    {
        $oauthParameters = require "config/oauth_config.php";

        if (!array_key_exists('provider', $_SESSION)) {
            if ($providerName !== null && array_key_exists($providerName, $oauthParameters)) {
                $_SESSION['provider'] = $providerName;
            } else {
                throw new InvalidArgumentException('Provider not set in session');
            }
        }

        return match ($_SESSION['provider']) {
            'google' => new Google($oauthParameters['google']),
            default => throw new InvalidArgumentException('Invalid provider name'),
        };
    }
}