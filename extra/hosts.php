<?php
include __DIR__ . "/../vendor/autoload.php";

use DrTeam\WPKG\Hosts;
$_hosts = new Hosts();

$hosts = [
    [
        'name' => 'host1',
        'profile' => 'custom'
    ],
    [
        'name' => 'host2',
        'profiles' => [
            'one', 'two', 'three'
        ]
    ]
];

echo $_hosts->create($hosts);
