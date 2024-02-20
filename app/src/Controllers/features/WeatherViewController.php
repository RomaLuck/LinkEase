<?php

namespace Src\Controllers\features;

use Src\Controllers\Controller;
use Src\Database;
use Symfony\Component\HttpFoundation\Session\Session;

class WeatherViewController extends Controller
{
    public function __invoke(Database $db, Session $session): void
    {
        $userId = $session->get('user')['id'];

        $userConfiguration = $db->query('SELECT * FROM user_settings WHERE user_id=:user_id', [
            'user_id' => $userId,
        ])->fetch();

        $this->render('weather-data.view.php', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
            'city' => $userConfiguration['city'] ?? '',
            'latitude' => $userConfiguration['latitude'] ?? '',
            'longitude' => $userConfiguration['longitude'] ?? '',
        ]);
    }
}