<?php

return [
    'google'=>[
        'clientId' => $_ENV['CLIENT_ID'],
        'clientSecret' => $_ENV['CLIENT_SECRET'],
        'redirectUri' => 'http://localhost:8000/connect/oauth/check',
    ]
];