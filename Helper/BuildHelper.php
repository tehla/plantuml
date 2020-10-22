<?php


namespace Tehla\PumlBundle\Helper;


use Doctrine\DBAL\Platforms\Keywords\MariaDb102Keywords;

class BuildHelper
{
    public static function format($replaceValue, $search): string
    {
        if(preg_match('/[A-Z]/', $search)){
            return MakerHelper::toCamelCase($replaceValue, false);
        }

        return $replaceValue;
    }


    public static function caseStartWithUnderscore($search, $replace)
    {
        return strpos($search, '_', 0) !== false
            && strpos($replace, '_', 0) !== false
            ;
    }

    public static function caseBelongsSubProperty($replace)
    {
        return strpos($replace, '.') !== false;
    }
}