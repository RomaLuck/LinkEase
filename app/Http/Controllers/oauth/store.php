<?php

use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;

$provider = SocialProviderFactory::getProvider();
$authenticator = new OAuthAuthenticator($provider);
$authenticator->authenticate();
