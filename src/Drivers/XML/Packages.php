<?php namespace WPKG\Drivers\XML;

/**
 * Class PackagesXML class with all basic parameters
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Drivers\XML
 */
class Packages
{
    /**
     * Current namespace
     * @var string
     */
    const ROOT = 'packages:packages';

    /**
     * List of attributes
     * @var array
     */
    const ROOT_ATTRIBUTES = [
        'xmlns:packages' => 'http://www.wpkg.org/packages',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/packages xsd/packages.xsd'
    ];

    /**
     * XSD schema of XML
     * @var string
     */
    const XSD = __DIR__ . '/../../vendor/wpkg/wpkg-js/xsd/packages.xsd';

    /**
     * Name of file on filesystem
     * @var string
     */
    const FILENAME = 'packages.xml';
}
