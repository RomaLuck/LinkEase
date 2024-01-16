<?php

use Core\Security\OAuthAuthenticator;
use Core\Security\SocialProviderFactory;

$providerName = $_GET['auth'];
$provider = SocialProviderFactory::getProvider($providerName);
$authenticator = new OAuthAuthenticator($provider);
$authenticator->start();