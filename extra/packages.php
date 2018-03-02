<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Package;
use \WPKG\Packages;

// Root container
$_packages = new Packages();

/**
 * Test package #1
 */
$pk1 = new Package();
$pk1->with('id', 'time')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always')
    ->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk1);

/**
 * Test package #2
 */
$pk2 = new Package();
$pk2->with('id', 'time2')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always')
    ->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk2);

/**
 * Test package #3
 */
$pk3 = new Package();
$pk3->with('id', 'time3')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always')
    ->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk3);

echo $_packages->show('yaml');
