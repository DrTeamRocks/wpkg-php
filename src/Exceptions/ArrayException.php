<?php namespace WPKG\Exceptions;

/**
 * Class ArrayException
 * @package WPKG\Exceptions
 */
class ArrayException extends Exceptions
{
    /**
     * Check if key in allowed list
     *
     * @param   string $key
     * @param   array $array
     * @throws  ArrayException
     */
    static function keyAllowed(string $key, array $array)
    {
        $line = implode(",", $array);
        if (!in_array($key, $array)) {
            throw new ArrayException("Key \"$key\" is not available in [$line] list.");
        }
    }

    /**
     * Check if key defined
     *
     * @param   string $key
     * @param   array $array
     * @throws  ArrayException
     */
    static function keyDefined(string $key, array $array)
    {
        if (!isset($array[$key])) {
            throw new ArrayException("Key \"$key\" is not defined.");
        }
    }

    /**
     * Check if element is object
     *
     * @param   mixed $object
     * @throws  ArrayException
     */
    static function isObject($object)
    {
        if (!is_object($object)) {
            throw new ArrayException("Is not an object.");
        }
    }
}
