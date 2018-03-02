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
    ->withVariable('PROG_FILES32', "%ProgramFiles%", ['architecture' => "x86"])
    ->withVariable('PROG_FILES32', "%ProgramFiles(x86)%", ['architecture' => "x64"])
    ->withVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", ['os' => "windows xp"])
    ->withVariable('DESKTOP', "%PUBLIC%\Desktop", ['os' => "Windows 7"]);


// Show current variant of generated XML
echo $_config->show('yaml');
