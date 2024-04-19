<?php

namespace Src\Http\Profile\Registration;

use Src\CountryListProvider;
use Src\Http\Controller;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;

class RegistrationViewController extends Controller
{
    public function __invoke(): Response
    {
        $cache = new FilesystemAdapter();
        $countryList = $cache->getItem('country-list');
        if (!$countryList->isHit()) {
            $countryList->set(CountryListProvider::getCountryList());
            $countryList->expiresAfter(3600);
            $cache->save($countryList);
        }

        return $this->render('Profile.Registration.create', [
            'countryList' => $countryList->get(),
            'timezoneApiKey' => $_ENV['TIMEZONE_API_KEY']
        ]);
    }
}
