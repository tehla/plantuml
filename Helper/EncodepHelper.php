<?php

namespace Tehla\PumlBundle\Helper;

require __DIR__ . '/../../../../vendor/autoload.php';

use function Jawira\PlantUml\encodep;

/**
 * @see https://plantuml.com/fr/code-php
 * Class EncodepHelper
 */
class EncodepHelper
{
    /**
     * @param $mdText
     * @return string
     * @throws \Exception
     */
    public static function encode($mdText)
    {
        return encodep($mdText);
    }
}
