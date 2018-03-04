<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Config;

$_config = new Config();

// Overwrite some attributes
$_config
    ->with('wpkg_base', 'http://example.com')
    ->with('quitonerror', true)
    ->with('debug', true);

// Now we can set the variables
$_config
    ->withVariable('PROG_FILES32', "%ProgramFiles%", null, "x86")
    ->withVariable('PROG_FILES32', "%ProgramFiles(x86)%",null, "x64")
    ->withVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", "Windows xp")
    ->withVariable('DESKTOP', "%PUBLIC%\Desktop", "Windows 7");


// Show current variant of generated XML
echo $_config->show('xml');
