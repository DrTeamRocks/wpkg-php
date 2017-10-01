<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Packages\Package;

$_packages = new Package();

// Set the path folder
$_packages->wpkg_path = __DIR__ . '/tmp';

// Overwrite the attributes of tha class
$_packages->id = 'time';
$_packages->name = 'Time Synchronization';
$_packages->priority = 100;
$_packages->execute = 'always';

// Small check for Windows 7
$_packages->setCheck('host', 'os', 'windows 7');

// Run command
$_packages->setCommand('install', 'net time \\timeserver /set /yes');

// Generate the XML from array in memory
$_packages->build();

// Show current variant of generated XML
echo $_packages->show();

// Save file on filesystem
$_packages->save();
