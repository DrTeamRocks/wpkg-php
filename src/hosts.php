<?php
include __DIR__ . "/../vendor/autoload.php";

use Spatie\ArrayToXml\ArrayToXml;

$array = [
    '_attributes' => [
        'xmlns:hosts' => 'http://www.wpkg.org/hosts',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/hosts xsd/hosts.xsd'
    ],
    'host' => [
        '_attributes' => [
            'name' => "hostname",
            'profile-id' => "custom"
        ]
    ],
];

echo ArrayToXml::convert($array, 'hosts:wpkg');
