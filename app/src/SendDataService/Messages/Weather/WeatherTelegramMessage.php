<?php

namespace Src\SendDataService\Messages\Weather;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Features\FeatureTypes;
use Src\SendDataService\Messages\MessageInterface;
use Src\SendDataService\MessageTypes;
use function Symfony\Component\String\u;

class WeatherTelegramMessage implements MessageInterface
{
    public function getMessage(ArrayCollection $data): string
    {
        $current = $data->get('current');
        $currentUnits = $data->get('current_units');
        $daily = $data->get('daily');
        $dailyUnits = $data->get('daily_units');

        $message = '';

        if (is_array($daily) && $daily !== []) {
            $dayNum = count($daily[array_key_first($daily)]);
            for ($i = 0; $i < $dayNum; $i++) {
                $message = "Daily:\n";
                foreach ($daily as $item => $value) {
                    if (is_array($value) && array_key_exists($i, $value) && array_key_exists($item, $dailyUnits)) {
                        $name = u($item)->replaceMatches('!\dm!iu', '')->replaceMatches('!_+!iu', ' ')->toString();
                        $message .= $name . " : " . $value[$i] . "(" . $dailyUnits[$item] . "), \n";
                    }
                }
            }
        }
        if (is_array($current) && $current !== []) {
            $message = "Current:\n";
            foreach ($current as $item => $value) {
                if (array_key_exists($item, $currentUnits)) {
                    $name = u($item)->replaceMatches('!\dm!iu', '')->replaceMatches('!_+!iu', ' ')->toString();
                    $message .= $name . " : " . $value . "(" . $currentUnits[$item] . "), \n";
                }
            }
        }
        return $message;
    }

    public function getFeature(): string
    {
        return FeatureTypes::WEATHER;
    }

    public function getMessenger(): string
    {
        return MessageTypes::BY_TELEGRAM;
    }
}