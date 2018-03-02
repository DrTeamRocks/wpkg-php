<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Package;

$_package = new Package();

// Overwrite the attributes of tha class
$_package
    ->with('id', 'time')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always');

// Small check for Windows 7
$_package->setCheck('host', 'os', 'windows 7');

// Run command
$_package->setCommand('install', 'net time \\timeserver /set /yes');

echo $_package->show('yaml');
