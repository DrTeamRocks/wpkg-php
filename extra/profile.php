<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Profile;

$_profile = new Profile();

// Set the path folder
$_profile->wpkg_path = __DIR__ . '/tmp';

// Append few hosts
$_profile->id = 'profile1';
$_profile->packages = 'DotNet';
$_profile->depends = 'profile2';

// Generate the XML from array in memory
$_profile->build();

// Show current variant of generated XML
echo $_profile->show();

// Save file on filesystem
$_profile->save();
