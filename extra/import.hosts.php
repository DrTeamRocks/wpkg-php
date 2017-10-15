<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Importers\Hosts;

$_hosts = new Hosts();
$_hosts->wpkg_path = __DIR__ . '/tmp';

// Import the single hosts.xml document
$_hosts->load();

// Read the single host data from main array
$host1 = $_hosts->get('host1');
echo $host1->build()->show();

// Generate the XML tree from imported file
$_hosts->build();

// Show result
$out = $_hosts->show();
echo $out;
