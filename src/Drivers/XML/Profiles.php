<?php namespace WPKG\Drivers\XML;

/**
 * Class ProfilesXML class with all basic parameters
 *
 * @link https://wpkg.org/Profiles.xml
 * @package WPKG\Classes\Profiles
 */
class Profiles
{
    /**
     * Current namespace
     * @var string
     */
    const ROOT = 'profiles:profiles';

    /**
     * List of attributes
     * @var array
     */
    const ROOT_ATTRIBUTES = [
        'xmlns:profiles' => 'http://www.wpkg.org/profiles',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/profiles xsd/profiles.xsd'
    ];

    /**
     * XSD schema of XML
     * @var string
     */
    const XSD = __DIR__ . '/../../vendor/wpkg/wpkg-js/xsd/profiles.xsd';

    /**
     * Name of file on filesystem
     * @var string
     */
    const FILENAME = 'profiles.xml';
}
