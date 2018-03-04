<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Drivers\XMLImport;

// Create new object
$_import = new XMLImport();

// Content of profiles file
$_hosts_file = file_get_contents(__DIR__. '/../vendor/wpkg/wpkg-js/profiles.xml');

// Read and parse file to normal format
$_package = $_import->import($_hosts_file);

// Print array to stdOut
print_r($_package);
