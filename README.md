![WPKG Logo](https://wpkg.org/wpkg.png)

# WPKG XML configuration generator

Library written on PHP7 for generating XML files with configuration for WPKG installer.

    composer require drteam/wpkg-php

Check [links](#some-links) for more info about WPKG.

If you need Active Directory support for generation `hosts.xml` from domain PCs you can
look at [WPKG-AD project](https://github.com/wpkg/wpkg-php-ad), which based on this library. 

# Table of Contents

- [How to create XML](#how-to-create-xml)
    - [Config](#config)
        - [Config.xml file](#configxml-file)
        - [Note about translations](#note-about-translations)
    - [Hosts](#hosts)
        - [Single host](#single-host)
        - [Hosts.xml file](#hostsxml-file)
        - [Computers from Active Directory](#computers-from-active-directory)
    - [Profiles](#profiles)
        - [Single profile](#single-profile)
        - [Profiles.xml file](#profilesxml-file)
    - [Packages](#packages)
        - [Single package](#single-package)
        - [Packages.xml file](#packagesxml-file)
- [How to import existed XML](#how-to-import-existed-xml)
    - [Import Config.xml file](#import-configxml-file)
- [Get Support](#get-support)
- [Some links](#some-links)

# How to create XML

Some examples with descriptions you can find [here](extra).

## Config

Configuration settings for runtime behavior of *wpkg.js*

### *Config.xml* file

Using the Config class, you can override the settings, if you specified
a value different from the default value, your parameter will be added
to the XML file.

If you do not specify anything, a configuration with default parameters
will be generated.

```php
$_config = new \WPKG\Config();

// Overwrite some attributes
$_config
    ->with('wpkg_base', 'http://example.com')
    ->with('quitonerror', true)
    ->with('debug', true);

// Now we can set the variables
$_config
    ->withVariable('PROG_FILES32', "%ProgramFiles%", null, "x86")
    ->withVariable('PROG_FILES32', "%ProgramFiles(x86)%", null, "x64")
    ->withVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", "Windows xp")
    ->withVariable('DESKTOP', "%PUBLIC%\Desktop", "Windows 7");


// Show current variant of generated XML
echo $_config->show();
```

Result of execution:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<config xmlns:profiles="http://www.wpkg.org/config" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/config xsd/config.xsd">
  <languages>
    ... a lot of lines with translations ...
  </languages>
  <param name="wpkg_base" value="http://example.com"/>
  <param name="quitonerror" value="true"/>
  <param name="debug" value="true"/>
  <variables>
    <variable name="PROG_FILES32" value="%ProgramFiles%" architecture="x86"/>
    <variable name="PROG_FILES32" value="%ProgramFiles(x86)%" architecture="x64"/>
    <variable name="DESKTOP" value="%ALLUSERSPROFILE%\Desktop" os="Windows xp"/>
    <variable name="DESKTOP" value="%PUBLIC%\Desktop" os="Windows 7"/>
  </variables>
</config>
```

### Note about translations

At the moment, translations (creators of the WPKG project call them languages) are available for the following languages:

* English
* French
* German
* Italian
* Russian (added by me)
* Spanish

Translations was taken from the *config.xml* file that was in the [wpkg-1.3.1-bin.zip](http://wpkg.org/files/stable/1.3.x/wpkg-1.3.1-bin.zip)
archive from the official website of the [WPKG project](https://wpkg.org/Download).

All available translations of *wpkg-php* you can find [here](src/Languages).

If you do not see your language on the list and want to help the project, then you
can suggest your translation variant via [issues](https://github.com/DrTeamRocks/wpkg-php/issues) or **PR**.
Pay attention to LCID, these are unique language identifiers, a complete list
of them you can find [here](http://www.microsoft.com/globaldev/reference/lcid-all.mspx).

## Hosts

Mappings between machine names and profile names.

### Single host

If you want generate few hosts in separated files:

```php
// Root container
$_host = new \WPKG\Host();

// Need to add some parameters
$_host
    ->with('name', 'host1')
    ->with('profile-id', 'profile1');

echo $_host->show();
```

Result is:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1"/>
</hosts:wpkg>
```

You also can set array of profiles:

```php
// Root container
$_host = new \WPKG\Host();

// Need to add some parameters
$_host
    ->with('name', 'host1')
    ->with('profile-id', ['profile1', 'profile2', 'profile3']);

echo $_host->show();
```

And in result must be:

```xml
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1">
    <profile profile-id="profile2"/>
    <profile profile-id="profile3"/>
  </host>
</hosts:wpkg>
```

### Hosts.xml file

If you need one large file with all your hosts:

```php
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

echo $_hosts->show();
```

Result file *hosts.xml* into the **wpkg_path** folder

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1"/>
  <host name="host2" profile-id="profile1">
    <profile profile-id="profile2"/>
    <profile profile-id="profile3"/>
  </host>
  <host name="host3" profile-id="profile3"/>
</hosts:wpkg>
```

### Computers from Active Directory

This class based on [adLdap library](https://github.com/adldap/adLDAP),
so you can use any configuration parameters from this library.

Basic usage:

```php
use \WPKG\Drivers\ADImport;

// Read AD configuration
$_config = include __DIR__ . '/adldap.php';

// Set Import object for work and put configuration inside
$_import = new ADImport($_config);

// You also can set config via specific method
//$_import->setConfig($_config);

// Choose work mode (only hosts available) and output the XML
$_hosts = $_import->import('hosts');
$out = $_hosts->show();

print_r($out);
```

You should saw something like this:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="user1.example.com" profile-id="default"/>
  <host name="user2.example.com" profile-id="default"/>
  <host name="user3.example.com" profile-id="default"/>
</hosts:wpkg>
```

## Profiles

Specifies which packages will be installed/executed for each WPKG profile.

### Single profile

If you want generate few profiles in separated files:

```php
use WPKG\Profile;

$_profile = new \WPKG\Profile();

$_profile
    ->with('id', 'profile1')
    ->with('packages', 'DotNet')
    ->with('depends', 'profile2');

// Show current variant of generated config
echo $_profile->show();
```

Result file (with name like <id>.xml, eg profile1.xml like in current example) you can find into the **wpkg_path**/profiles/ subfolder:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<profiles:profiles xmlns:profiles="http://www.wpkg.org/profiles" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/profiles xsd/profiles.xsd">
  <profile id="profile1">
    <depends profile-id="profile2"/>
    <package package-id="DotNet"/>
  </profile>
</profiles:profiles>
```

You as in hosts also can set array of `packages` or `depends`.

### Profiles.xml file

If you need one large file with all your profiles:

```php
$_profiles = new \WPKG\Profiles();

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
```

Result:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<profiles:profiles xmlns:profiles="http://www.wpkg.org/profiles" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/profiles xsd/profiles.xsd">
  <profile id="profile1"/>
  <profile id="profile2">
    <package package-id="DotNet"/>
  </profile>
  <profile id="profile3">
    <depends profile-id="profile1"/>
    <package package-id="Firefox"/>
    <package package-id="Chromium"/>
    <package package-id="Opera"/>
  </profile>
  <profile id="profile4">
    <depends profile-id="profile1"/>
    <depends profile-id="profile2"/>
    <package package-id="SuperBank"/>
    <package package-id="AnotherBank"/>
  </profile>
  <profile id="profile5">
    <depends profile-id="profile3"/>
  </profile>
</profiles:profiles>
```

## Packages

Defines software packages (commands for WPKG to install/uninstall programs, etc.)

### Single package

If you want generate few packages in separated files:

```php
use \WPKG\Package;
use \WPKG\PackageCheckExits;

$_package = new Package();
$_exits = new PackageCheckExits();

// Overwrite the attributes of tha class
$_package
    ->with('id', 'wpkg1')
    ->with('name', 'Windows Packager sample 1')
    ->with('revision', 1)
    ->with('priority', 0)
    ->with('reboot', 'false');

// Small check for Windows 7
$_package
    ->withCheck('registry', 'exists', 'HKLM\Software\wpkg\full\key\not\part\of\it')
    ->withCheck('file', 'exists', 'C:\wpkg\wpkg.bat')
    ->withCheck('uninstall', 'exists', 'WPKG 0.6-test1');

// Add few variables to package config
$_package
    ->withVariable('PROG_FILES32', "%ProgramFiles(x86)%", null, "x64")
    ->withVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", "Windows xp");

// We need set exit codes for some installation stages
$_exits
    ->add(0)
    ->add(3010, true)
    ->add('any')
    ->add(2);

// Run command
$_package
    ->withCommand('install', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"', 'test', $_exits)
    ->withCommand('remove', 'msiexec /x /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('upgrade', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('downgrade', null, 'remove')
    ->withCommand('downgrade', null, 'install');

echo $_package->show();
```

Result:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<packages:packages xmlns:packages="http://www.wpkg.org/packages" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/packages xsd/packages.xsd">
  <package id="wpkg1" name="Windows Packager sample 1" revision="1" priority="0" reboot="false">
    <check type="registry" condition="exists" path="HKLM\Software\wpkg\full\key\not\part\of\it"/>
    <check type="file" condition="exists" path="C:\wpkg\wpkg.bat"/>
    <check type="uninstall" condition="exists" path="WPKG 0.6-test1"/>
    <variable name="PROG_FILES32" value="%ProgramFiles(x86)%" architecture="x64"/>
    <variable name="DESKTOP" value="%ALLUSERSPROFILE%\Desktop" os="Windows xp"/>
    <commands>
      <command type="install" cmd='msiexec /i /qn "%SOFTWARE%\path\to\msi"' include="test">
        <exit code="0"/>
        <exit code="3010" reboot="true"/>
        <exit code="any"/>
        <exit code="2"/>
      </command>
      <command type="remove" cmd='msiexec /x /qn "%SOFTWARE%\path\to\msi"'/>
      <command type="upgrade" cmd='msiexec /i /qn "%SOFTWARE%\path\to\msi"'/>
      <command type="downgrade" include="remove"/>
      <command type="downgrade" include="install"/>
    </commands>
  </package>
</packages:packages>
```

### Packages.xml file

If you need one large file with all your packages:

```php
use \WPKG\Package;
use \WPKG\PackageCheckExits;
use \WPKG\Packages;

// Root container
$_packages = new Packages();

/**
 * Test package #1
 */
$pk1 = new Package();
$pk1->with('id', 'time')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always')
    ->withCheck('host', 'os', 'windows 7')
    ->withCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk1);

/**
 * Test package #2
 */
$pk2 = new Package();
$pk2_exits = new PackageCheckExits();

// We need set exit codes for some installation stages
$pk2_exits
    ->add(0)
    ->add(3010, true)
    ->add('any')
    ->add(2);

$pk2->with('id', 'wpkg')
    ->with('name', 'Windows Packager sample 1')
    ->with('revision', 1)
    ->with('priority', 0)
    ->with('reboot', 'false')
    ->withCheck('registry', 'exists', 'HKLM\Software\wpkg\full\key\not\part\of\it')
    ->withCheck('file', 'exists', 'C:\wpkg\wpkg.bat')
    ->withCheck('uninstall', 'exists', 'WPKG 0.6-test1')
    ->withCommand('install', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"', 'test', $pk2_exits)
    ->withCommand('remove', 'msiexec /x /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('upgrade', 'msiexec /i /qn "%SOFTWARE%\path\to\msi"')
    ->withCommand('downgrade', null, 'remove')
    ->withCommand('downgrade', null, 'install');

$_packages->setPackage($pk2);

/**
 * Test package #3
 */
$pk3 = new Package();
$pk3->with('id', 'time3')
    ->with('name', 'Time Synchronization')
    ->with('priority', 100)
    ->with('execute', 'always')
    ->withCheck('host', 'os', 'windows 7')
    ->withCommand('install', 'net time \\timeserver /set /yes');

$_packages->setPackage($pk3);

echo $_packages->show();
```

Result:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<packages:packages xmlns:packages="http://www.wpkg.org/packages" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/packages xsd/packages.xsd">
  <package id="time" name="Time Synchronization" priority="100" execute="always">
    <check type="host" condition="os" path="windows 7"/>
    <commands>
      <command type="install" cmd="net time \timeserver /set /yes"/>
    </commands>
  </package>
  <package id="wpkg" name="Windows Packager sample 1" revision="1" priority="0" reboot="false">
    <check type="registry" condition="exists" path="HKLM\Software\wpkg\full\key\not\part\of\it"/>
    <check type="file" condition="exists" path="C:\wpkg\wpkg.bat"/>
    <check type="uninstall" condition="exists" path="WPKG 0.6-test1"/>
    <commands>
      <command type="install" cmd="msiexec /i /qn &quot;%SOFTWARE%\path\to\msi&quot;" include="test">
        <exit code="0"/>
        <exit code="3010" reboot="true"/>
        <exit code="any"/>
        <exit code="2"/>
      </command>
      <command type="remove" cmd="msiexec /x /qn &quot;%SOFTWARE%\path\to\msi&quot;"/>
      <command type="upgrade" cmd="msiexec /i /qn &quot;%SOFTWARE%\path\to\msi&quot;"/>
      <command type="downgrade" include="remove"/>
      <command type="downgrade" include="install"/>
    </commands>
  </package>
  <package id="time3" name="Time Synchronization" priority="100" execute="always">
    <check type="host" condition="os" path="windows 7"/>
    <commands>
      <command type="install" cmd="net time \timeserver /set /yes"/>
    </commands>
  </package>
</packages:packages>
```

# How to import existed XML

## Import Config.xml file

First you need enable the importer class

```php
use \WPKG\Drivers\XMLImport;

// Create new object
$_import = new XMLImport();

// Content of hosts file
$_hosts_file = file_get_contents('config.xml');

// Read and parse file to normal format
$_hosts = $_import->import($_hosts_file);

// Print array to stdOut
print_r($_hosts);
```

Now inside `$_hosts` variable you can find the [\WPKG\Hosts](#hostsxml-file) object with all hosts which was imported.

Same operation for all other configurations, library can check which config you are loaded.

# Get Support!

* [Discord](https://discord.gg/vRjVfHK) - Join us on Discord.
* [GitHub Issues](https://github.com/wpkg/wpkg-php/issues) - Got issues? Please tell us!
* [Roadmap](https://github.com/wpkg/wpkg-php/wiki) - Want to contribute? Get involved!

# Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
* Article on Wikipedia - https://en.wikipedia.org/wiki/WPKG_(software)
