<?php namespace WPKG\Drivers\XML;

/**
 * Class HostsXML class with all basic parameters
 *
 * @link https://wpkg.org/Hosts.xml
 * @package WPKG\Drivers\XML
 */
class Hosts
{
    /**
     * Current namespace
     * @var string
     */
    const ROOT = 'hosts:wpkg';

    /**
     * List of attributes
     * @var array
     */
    const ROOT_ATTRIBUTES = [
        'xmlns:hosts' => 'http://www.wpkg.org/hosts',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/hosts xsd/hosts.xsd'
    ];

    /**
     * XSD schema of XML
     * @var string
     */
    const XSD = __DIR__ . '/../../vendor/wpkg/wpkg-js/xsd/hosts.xsd';

    /**
     * Name of file on filesystem
     * @var string
     */
    const FILENAME = 'hosts.xml';
}
