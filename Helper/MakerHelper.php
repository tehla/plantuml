<?php


namespace Tehla\PumlBundle\Helper;


use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;

class MakerHelper
{
    public static function toCamelCase($str, $lcfirst = true)
    {
        if (is_array($str)) {
            return array_map(function($s) use ($lcfirst) {
                return self::toCamelCase($s, $lcfirst);
            }, $str);
        }
        $str = str_replace('-', '', ucwords($str, '-'));
        $str = str_replace('_', '', ucwords($str, '_'));
        return $lcfirst ? lcfirst($str) : $str;
    }

    public static function getNamespace(ClassNameDetails $details)
    {
        $shards = explode('\\', $details->getFullName());
        array_pop($shards);

        return implode('\\', $shards);
    }

    public static function cleanConfig(array &$config)
    {
        if (isset($config['types'])) {
            $config['CamelTypes'] = self::toCamelCase($config['types'], false);
            $config['camelTypes'] = self::toCamelCase($config['types']);
        }
        if (isset($config['with']) ) {
            $config['CamelWith'] = self::toCamelCase($config['with'], false);
            $config['camelWith'] = self::toCamelCase($config['with']);
        }

        if (!isset($config['camelWith'])) {
            return;
        }
        foreach ($config['camelWith'] as $it) {
            if (!is_array($it)) {
                $config['properties'][] = $it;
                continue;
            }
            foreach ($it as $i) {
                $config['properties'][] = $i;
            }
        }
        $config['properties'] = array_unique($config['properties']);
    }
}
