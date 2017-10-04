<?php namespace WPKG\Classes\Config;

use WPKG\Classes\XML;

/**
 * Class PackagesXML class with all basic parameters
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Hosts
 */
class XMLOptions extends XML
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'config';

    /**
     * List of attributes
     * @var array
     */
    protected $_root_attributes = [
        'xmlns:profiles' => 'http://www.wpkg.org/config',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/config xsd/config.xsd'
    ];
}
