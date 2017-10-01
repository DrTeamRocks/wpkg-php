<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Config;

$_config = new Config();

// Set the path folder
$_config->wpkg_path = __DIR__ . '/tmp';

// Overwrite some attributes
$_config->wpkg_base = 'http://example.com';
$_config->quitonerror = true;
$_config->debug = true;

// Now we can set the variables
$_config->setVariable('PROG_FILES32', "%ProgramFiles%", ['architecture' => "x86"]);
$_config->setVariable('PROG_FILES32', "%ProgramFiles(x86)%", ['architecture' => "x64"]);
$_config->setVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", ['os' => "windows xp"]);
$_config->setVariable('DESKTOP', "%PUBLIC%\Desktop", ['os' => "Windows 7"]);

// Generate the XML from array in memory
$_config->build();

// Show current variant of generated XML
echo $_config->show();

// Save file on filesystem
$_config->save();
