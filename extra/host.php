<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Host;

// Root container
$_host = new Host();
$_host->wpkg_path = __DIR__ . '/tmp';

// Set the hostname
$_host->name = 'host1';
// Set single profile or profiles array
$_host->profileId = 'profile1';

// Generate the XML from array in memory
$_host->build();

// Show current variant of generated XML
echo $_host->show();

// Save file on filesystem
$_host->save();
