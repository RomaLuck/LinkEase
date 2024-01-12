<?php

use Core\OAuthAuthenticator;
use Core\SocialProviderFactory;

$provider = SocialProviderFactory::getProvider();
$authenticator = new OAuthAuthenticator($provider);
$authenticator->authenticate();
