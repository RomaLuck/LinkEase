<?php

use Core\OAuthAuthenticator;
use Core\SocialProviderFactory;

$providerName = $_GET['auth'];
$provider = SocialProviderFactory::getProvider($providerName);
$authenticator = new OAuthAuthenticator($provider);
$authenticator->start();