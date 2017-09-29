<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Hosts;
$_hosts = new Hosts();

// Set the path folder
$_hosts->path = __DIR__ . '/../tmp';

// Append few hosts
$_hosts->add('host1', 'custom');
$_hosts->add('host2', ['one', 'two', 'three']);
$_hosts->add('host3', 'another');

// Generate the XML from array in memory
$_hosts->build();

// Show current variant of generated XML
echo $_hosts->show();

// Save file on filesystem
$_hosts->save();
