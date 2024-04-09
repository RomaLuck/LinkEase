<?php

namespace Src\SendDataService\Messages\Weather;

use Doctrine\Common\Collections\ArrayCollection;
use Src\SendDataService\Messages\MessageInterface;
use function Symfony\Component\String\u;

class WeatherEmailMessage implements MessageInterface
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
                $message .= "<h4>Daily:</h4>";
                foreach ($daily as $item => $value) {
                    if (is_array($value) && array_key_exists($i, $value) && array_key_exists($item, $dailyUnits)) {
                        $name = u($item)->replaceMatches('!\dm!iu', '')->replaceMatches('!_+!iu', ' ')->toString();
                        $message .= "<p><b>" . $name . "</b> : " . $value[$i] . "(" . $dailyUnits[$item] . "), </p>";
                    }
                }
            }
        }
        if (is_array($current) && $current !== []) {
            $message .= "<h4>Current:</h4>";
            foreach ($current as $item => $value) {
                if (array_key_exists($item, $currentUnits)) {
                    $name = u($item)->replaceMatches('!\dm!iu', '')->replaceMatches('!_+!iu', ' ')->toString();
                    $message .= "<p><b>" . $name . "</b> : " . $value . "(" . $currentUnits[$item] . "), </p>";
                }
            }
        }

        if ($message === '') {
            throw new \RuntimeException('Message is empty');
        }

        return $message;
    }
}