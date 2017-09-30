<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Config;

$_config = new Config();

// Set the path folder
$_config->path = __DIR__ . '/tmp';

// Overwrite some attributes
$_config->wpkg_base = 'http://example.com';
$_config->quitonerror = true;
$_config->debug = true;

// Generate the XML from array in memory
$_config->build();

// Show current variant of generated XML
echo $_config->show();

// Save file on filesystem
$_config->save();
