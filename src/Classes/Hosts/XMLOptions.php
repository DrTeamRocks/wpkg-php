<?php namespace WPKG\Classes\Hosts;

use WPKG\XML;

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
    protected $_root = 'hosts:wpkg';

    /**
     * List of attributes
     * @var array
     */
    protected $_root_attributes = [
        'xmlns:hosts' => 'http://www.wpkg.org/hosts',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/hosts xsd/hosts.xsd'
    ];
}
