<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Host;
use WPKG\Hosts;

// Root container
$_hosts = new Hosts();

/**
 * Test host #1
 */
$host1 = new Host();
$host1
    ->with('name', 'host1')
    ->with('profile-id', 'profile1');

$_hosts->setHost($host1);

/**
 * Test host #2
 */
$host2 = new Host();
$host2
    ->with('name', 'host2')
    ->with('profile-id', ['profile1', 'profile2', 'profile3']);

$_hosts->setHost($host2);

/**
 * Test host #3
 */
$host3 = new Host();
$host3
    ->with('name', 'host3')
    ->with('profile-id', 'profile3');

$_hosts->setHost($host3);

//echo $_hosts->show('yaml');
echo $_hosts->show('xml');
