<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Package;
use \WPKG\PackageCheckExits;
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
    ->withCheck('host', 'os', 'windows 7')
    ->withCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk1);

/**
 * Test package #2
 */
$pk2 = new Package();
$pk2_exits = new PackageCheckExits();

// We need set exit codes for some installation stages
$pk2_exits
    ->add(0)
    ->add(3010, true)
    ->add('any')
    ->add(2);

$pk2->with('id', 'wpkg')
    ->with('name', 'Windows Packager sample 1')
    ->with('revision', 1)
    ->with('priority', 0)
    ->with('reboot', 'false')
    ->withCheck('registry', 'exists', 'HKLM\Software\wpkg\full\key\not\part\of\it')
    ->withCheck('file', 'exists', 'C:\wpkg\wpkg.bat')
    ->withCheck('uninstall', 'exists', 'WPKG 0.6-test1')
    ->withCommand('install', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"', 'test', $pk2_exits)
    ->withCommand('remove', 'msiexec /x /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('upgrade', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('downgrade', null, 'remove')
    ->withCommand('downgrade', null, 'install');

$_packages->setPackage($pk2);

/**
 * Test package #3
 */
$pk3 = new Package();
$pk3->with('id', 'time3')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always')
    ->withCheck('host', 'os', 'windows 7')
    ->withCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk3);

echo $_packages->show();
