<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Importers\Hosts;

$_hosts = new Hosts();
$_hosts->wpkg_path = __DIR__ . '/tmp';

// Import the single hosts.xml document
$_hosts->load();

// Build the tree by imported file
$_hosts->build();

echo "\n>>> Original file\n";
echo $_hosts->read();
echo "\n";

echo "\n>> Imported file\n";
echo $_hosts->show();
echo "\n";

echo "\n>> Read the single host data from main array\n";
$host = $_hosts->get('host1');
echo $host->show();
echo "\n";
$host = $_hosts->get('host2');
echo $host->show();
echo "\n";
