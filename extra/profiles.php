<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Profiles;
use \WPKG\Profile;

$_profiles = new Profiles();
$_profiles->wpkg_path = __DIR__ . '/tmp';

/**
 * Test profile #1
 */
$pr1 = new Profile();
$pr1->id = 'profile1';

$_profiles->set($pr1);

/**
 * Test profile #2
 */
$pr2 = new Profile();
$pr2->id = 'profile2';
$pr2->packages = 'DotNet';

$_profiles->set($pr2);

/**
 * Test profile #3
 */
$pr3 = new Profile();
$pr3->id = 'profile3';
$pr3->packages = ['Firefox', 'Chromium', 'Opera'];
$pr3->depends = 'profile1';

$_profiles->set($pr3);

/**
 * Test profile #4
 */
$pr4 = new Profile();
$pr4->id = 'profile4';
$pr4->packages = ['SuperBank', 'AnotherBank'];
$pr4->depends = ['profile1', 'profile2'];

$_profiles->set($pr4);

/**
 * Test profile #5
 */
$pr5 = new Profile();
$pr5->id = 'profile5';
$pr5->depends = 'profile3';

$_profiles->set($pr5);

// Generate the XML from array in memory
$_profiles->build();

// Show current variant of generated XML
echo $_profiles->show();

// Save file on filesystem
$_profiles->save();
