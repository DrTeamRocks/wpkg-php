<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Packages;

$_packages = new Packages();

// Set the path folder
$_packages->path = __DIR__ . '/tmp';

// Overwrite the attributes of tha class
$_packages->id = 'ubuntu';
$_packages->name = 'The Ubuntu distribution on the fucking Windows OS';

// Generate the XML from array in memory
$_packages->build();

// Show current variant of generated XML
echo $_packages->show();

// Save file on filesystem
//$_packages->save();
