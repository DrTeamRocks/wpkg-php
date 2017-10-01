<?php namespace WPKG\Classes\Packages;

use WPKG\XML;

/**
 * Class PackagesXML abstract class with all basic parameters
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Packages
 */
abstract class PackagesXML extends XML
{
    /**
     * Current namespace
     * @var string
     */
    public $_root = 'packages:packages';

    /**
     * List of attributes
     * @var array
     */
    public $_root_attributes = [
        'xmlns:packages' => 'http://www.wpkg.org/packages',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/packages xsd/packages.xsd'
    ];
}
