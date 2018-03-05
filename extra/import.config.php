<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Drivers\XMLImport;

// Create new object
$_import = new XMLImport();

// Content of config file
$_file = file_get_contents(__DIR__. '/../vendor/wpkg/wpkg-js/config.xml');

// Read and parse file to normal format
$_config = $_import->import($_file);

// Print array to stdOut
print_r($_config);
