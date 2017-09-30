<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Config;

$_hosts = new Config();

// Set the path folder
$_hosts->path = __DIR__ . '/tmp';

// Generate the XML from array in memory
$_hosts->build();

// Show current variant of generated XML
echo $_hosts->show();
