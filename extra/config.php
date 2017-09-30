<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Config;

$_hosts = new Config();

// Set the path folder
$_hosts->path = __DIR__ . '/tmp';

// Overwrite some attributes
$_hosts->wpkg_base = 'http://example.com';
$_hosts->quitonerror = true;
$_hosts->debug = true;

// Generate the XML from array in memory
$_hosts->build();

// Show current variant of generated XML
echo $_hosts->show();

// Save file on filesystem
$_hosts->save();
