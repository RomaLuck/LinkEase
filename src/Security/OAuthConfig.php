<?php

namespace Src\Security;

class OAuthConfig
{
    private array $config;

    public function __construct()
    {
        $this->config = [
            'google' => [
                'clientId' => $_ENV['CLIENT_ID'] ?? '',
                'clientSecret' => $_ENV['CLIENT_SECRET'] ?? '',
                'redirectUri' => 'http://localhost:8000/connect/oauth/check',
            ]
        ];
    }

    public function getProviderConfig(string $provider): array
    {
        return $this->config[$provider] ?? [];
    }
}