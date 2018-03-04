<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Host;

// Root container
$_host = new Host();

// Need to add some parameters
$_host
    ->with('name', 'host1')
    ->with('profile-id', 'profile1');

echo $_host->show();

// Root container
$_host = new Host();

// Need to add some parameters
$_host
    ->with('name', 'host1')
    ->with('profile-id', ['profile1', 'profile2', 'profile3']);

echo $_host->show();
