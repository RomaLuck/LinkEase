<?php

namespace Src;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CountryListProvider
{
    /**
     * @throws \JsonException
     * @throws GuzzleException
     */
    public static function getCountryList(): array
    {
        $client = new Client();
        $responseJson = $client->get('https://pkgstore.datahub.io/core/country-list/data_json/data/8c458f2d15d9f2119654b29ede6e45b8/data_json.json')
            ->getBody()
            ->getContents();

        return json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
    }
}