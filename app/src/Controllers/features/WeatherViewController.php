<?php

namespace Src\Controllers\features;

use Src\Controllers\Controller;
use Src\Database;
use Src\Session;

class WeatherViewController extends Controller
{
    public function __invoke(Database $db): void
    {
        $userId = Session::get('user')['id'];

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