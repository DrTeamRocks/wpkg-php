<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Host;

// Root container
$_host = new Host();

$_host
    ->with('name', 'host1')
    ->with('profileId', 'asd');

echo $_host->show('yaml');
