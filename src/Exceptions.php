<?php namespace WPKG;

/**
 * Class Exceptions
 * @package WPKG
 */
class Exceptions
{
    /**
     * @param string $key
     * @param array $array
     * @throws \Exception
     */
    static function arrayKeyAllowed(string $key, array $array)
    {
        $line = implode(",", $array);
        if (!in_array($key, $array)) {
            throw new \Exception("Key \"$key\" is not available in [$line] list.");
        }
    }

    /**
     * @param string $key
     * @param array $array
     * @throws \Exception
     */
    static function arrayKeyDefined(string $key, array $array)
    {
        if (!isset($array[$key])) {
            throw new \Exception("Key \"$key\" is not defined.");
        }
    }
}
