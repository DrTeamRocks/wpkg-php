<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Hosts;

$_hosts = new Hosts();

// Set the path folder
$_hosts->path = __DIR__ . '/tmp';

// Append few hosts
$_hosts->set('host1', 'profile1');
$_hosts->set('host2', ['profile1', 'profile2', 'profile3']);
$_hosts->set('host3', 'profile3');

// Generate the XML from array in memory
$_hosts->build();

// Show current variant of generated XML
echo $_hosts->show();

// Save file on filesystem
$_hosts->save();
