<?php
require_once __DIR__ . "/../vendor/autoload.php";

use \WPKG\AD\Hosts;

$_hosts = new Hosts(true);
$_hosts->wpkg_path = __DIR__ . '/tmp';
$_hosts->setConfig('adldap', require_once __DIR__ . '/adldap.php');

// Generate the XML tree object by data from AD
$_hosts->build(true);

// Output the XML
echo $_hosts->show();

// Save hosts.xml file into the /path/to/wpkg (replace if exist)
$_hosts->save();
