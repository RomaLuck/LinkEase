<?php

namespace Src\SendDataService\Messages;

use Doctrine\Common\Collections\ArrayCollection;
use function Symfony\Component\String\u;

class WeatherMessage implements MessageInterface
{
    public function __construct(private ArrayCollection $data)
    {
    }

    public function getMessage(): string
    {
        $current = $this->data->get('current');
        $currentUnits = $this->data->get('current_units');
        $daily = $this->data->get('daily');
        $dailyUnits = $this->data->get('daily_units');
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