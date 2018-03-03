<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Package;
use WPKG\PackageCheckExits;

$_package = new Package();
$_exits = new PackageCheckExits();

// Overwrite the attributes of tha class
$_package
    ->with('id', 'wpkg1')
    ->with('name', 'Windows Packager sample 1')
    ->with('revision', 1)
    ->with('priority', 0)
    ->with('reboot', 'false');

// Small check for Windows 7
$_package
    ->withCheck('registry', 'exists', 'HKLM\Software\wpkg\full\key\not\part\of\it')
    ->withCheck('file', 'exists', 'C:\wpkg\wpkg.bat')
    ->withCheck('uninstall', 'exists', 'WPKG 0.6-test1');

// We need set exit codes for some installation stages
$_exits
    ->add(0)
    ->add(3010, true)
    ->add('any')
    ->add(2);

// Run command
$_package
    ->withCommand('install', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"', 'test', $_exits->get())
    ->withCommand('remove', 'msiexec /x /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('upgrade', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('downgrade', null, 'remove')
    ->withCommand('downgrade', null, 'install');

echo $_package->show();
