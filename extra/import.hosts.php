<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Drivers\XMLImport;

// Create new object
$_import = new XMLImport();

// Content of hosts file
$_hosts_file = file_get_contents(__DIR__. '/../vendor/wpkg/wpkg-js/hosts.xml');

// Read and parse file to normal format
$out = $_import->import($_hosts_file);

// Print array to stdOut
print_r($out);
