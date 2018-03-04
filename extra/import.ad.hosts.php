<?php
require_once __DIR__ . "/../vendor/autoload.php";

use \WPKG\Drivers\ADImport;

// Read AD configuration
$_config = include __DIR__ . '/adldap.php';

// Set Import object for work and put configuration inside
$_import = new ADImport($_config);

// You also can set config via specific method
//$_import->setConfig($_config);

// Choose work mode (only hosts available) and output the XML
$_hosts = $_import->import('hosts');
$out = $_hosts->show();

print_r($out);
