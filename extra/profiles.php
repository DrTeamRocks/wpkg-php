<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Profiles;

$_profiles = new Profiles();

// Set the path folder
$_profiles->wpkg_path = __DIR__ . '/tmp';

// Append few hosts
$_profiles->set('profile0');
$_profiles->set('profile1', 'DotNet');
$_profiles->set('profile2', ['Firefox', 'Chromium', 'Opera'], 'profile1');
$_profiles->set('profile3', ['SuperBank', 'AnotherBank'], ['profile1', 'profile2']);
$_profiles->set('profile4', null, 'profile3');

// Generate the XML from array in memory
$_profiles->build();

// Show current variant of generated XML
echo $_profiles->show();

// Save file on filesystem
$_profiles->save();
