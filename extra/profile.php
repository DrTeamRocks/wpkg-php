<?php
include __DIR__ . "/../vendor/autoload.php";

use WPKG\Profile;

$_profile = new Profile();

$_profile
    ->with('id', 'profile1')
    ->with('packages', 'DotNet')
    ->with('depends', 'profile2');

// Show current variant of generated config
echo $_profile->show();
