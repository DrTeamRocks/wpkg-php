<?php namespace WPKG\Drivers\XML;

/**
 * Class ConfigXML class with all basic parameters
 *
 * @link https://wpkg.org/Config.xml
 * @package WPKG\Drivers\XML
 */
class Config
{
    /**
     * Current namespace
     * @var string
     */
    const ROOT = 'config';

    /**
     * List of attributes
     * @var array
     */
    const ROOT_ATTRIBUTES  = [
        'xmlns:profiles' => 'http://www.wpkg.org/config',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/config xsd/config.xsd'
    ];

    /**
     * XSD schema of XML
     * @var string
     */
    const XSD = __DIR__ . '/../../vendor/wpkg/wpkg-js/xsd/config.xsd';

}
