<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Importers\Hosts;

$_hosts = new Hosts();

// Content of hosts file
$_hosts_file = file_get_contents(__DIR__. '/tmp/profiles.xml');

$out = $_hosts->convert($_hosts_file);
print_r($out);die();