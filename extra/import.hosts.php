<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Drivers\XMLImport;
use WPKG\Hosts;

$_import = new XMLImport();
$_hosts = new Hosts();

// Content of hosts file
$_hosts_file = file_get_contents(__DIR__. '/tmp/hosts.xml');

$out = $_import->convert($_hosts_file);
print_r($out);die();
