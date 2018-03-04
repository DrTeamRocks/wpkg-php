<?php
include __DIR__ . "/../vendor/autoload.php";

use \WPKG\Profiles;
use \WPKG\Profile;

$_profiles = new Profiles();

/**
 * Test profile #1
 */
$pr1 = new Profile();
$pr1->with('id', 'profile1');

$_profiles->setProfile($pr1);

/**
 * Test profile #2
 */
$pr2 = new Profile();
$pr2->with('id', 'profile2')
    ->with('packages', 'DotNet');

$_profiles->setProfile($pr2);

/**
 * Test profile #3
 */
$pr3 = new Profile();
$pr3->with('id', 'profile3')
    ->with('packages', ['Firefox', 'Chromium', 'Opera'])
    ->with('depends', 'profile1');

$_profiles->setProfile($pr3);

/**
 * Test profile #4
 */
$pr4 = new Profile();
$pr4->with('id', 'profile4')
    ->with('packages', ['SuperBank', 'AnotherBank'])
    ->with('depends', ['profile1', 'profile2']);

$_profiles->setProfile($pr4);

/**
 * Test profile #5
 */
$pr5 = new Profile();
$pr5->with('id', 'profile5')
    ->with('depends', 'profile3');

$_profiles->setProfile($pr5);

// Show current variant of generated config
echo $_profiles->show();
