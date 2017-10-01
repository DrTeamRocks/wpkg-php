<?php namespace WPKG\Classes\Profiles;

use WPKG\XML;

/**
 * Class PackagesXML class with all basic parameters
 *
 * @link https://wpkg.org/Profiles.xml
 * @package WPKG\Classes\Profiles
 */
class XMLOptions extends XML
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'profiles:profiles';

    /**
     * List of attributes
     * @var array
     */
    protected $_root_attributes = [
        'xmlns:profiles' => 'http://www.wpkg.org/profiles',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/profiles xsd/profiles.xsd'
    ];
}
