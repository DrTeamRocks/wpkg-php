<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Host;
use WPKG\Hosts;

// Root container
$_hosts = new Hosts();
$_hosts->wpkg_path = __DIR__ . '/tmp';

/**
 * Test host #1
 */
$host1 = new Host();
$host1->name = 'host1';
$host1->profileId = 'profile1';

$_hosts->set($host1);

/**
 * Test host #2
 */
$host2 = new Host();
$host2->name = 'host2';
$host2->profileId = ['profile1', 'profile2', 'profile3'];

$_hosts->set($host2);

/**
 * Test host #3
 */
$host3 = new Host();
$host3->name = 'host3';
$host3->profileId = 'profile3';

$_hosts->set($host3);

// Generate the XML from array in memory
$_hosts->build();

// Show current variant of generated XML
echo $_hosts->show();

// Save file on filesystem
$_hosts->save();
