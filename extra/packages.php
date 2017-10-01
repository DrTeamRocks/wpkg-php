<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Package;
use \WPKG\Packages;

$_packages = new Packages();
$_packages->wpkg_path = __DIR__ . '/tmp';

/**
 * Test package #1
 */
$pk1 = new Package();
$pk1->id = 'time';
$pk1->name = 'Time Synchronization';
$pk1->priority = 100;
$pk1->execute = 'always';
$pk1->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->set($pk1);

/**
 * Test package #2
 */
$pk2 = new Package();
$pk2->id = 'time2';
$pk2->name = 'Time Synchronization';
$pk2->priority = 100;
$pk2->execute = 'always';
$pk2->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->set($pk2);

/**
 * Test package #3
 */
$pk3 = new Package();
$pk3->id = 'time3';
$pk3->name = 'Time Synchronization';
$pk3->priority = 100;
$pk3->execute = 'always';
$pk3->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->set($pk3);

$_packages->build();
echo $_packages->show();
$_packages->save();
