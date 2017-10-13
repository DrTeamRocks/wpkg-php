![WPKG Logo](https://wpkg.org/wpkg.png)

# WPKG XML configuration generator

Library written on PHP7 for generating XML files with configuration for WPKG installer.

    composer require drteam/wpkg-php

Check [links](#some-links) for more info about WPKG.

# Table of Contents

- [Simple how to](#simple-how-to)
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
- [RoadMap](#roadmap)
- [Some links](#some-links)

# Simple how to

Almost all classes have several identical methods:

    build() - Execute the XML tree generation
    show() - Return ready for STDOUT generated XML
    save() - Create (replace if exist) new file on filesystem

    Note: Don't forget execute "build()" method before you run "show()" or "save()".

Any other examples with descriptions you can find [here](extra).

## Config

Configuration settings for runtime behavior of *wpkg.js*

### *Config.xml* file

Using the Config class, you can override the settings, if you specified
a value different from the default value, your parameter will be added
to the XML file.

If you do not specify anything, a configuration with default parameters
will be generated.

```php
$config = new \WPKG\Config();
$config->wpkg_path = '/path/to/wpkg';

$config->wpkg_base = 'http://example.com';
$config->quitonerror = true;
$config->debug = true;

$config
    ->setVariable('PROG_FILES32', "%ProgramFiles%", ['architecture' => "x86"])
    ->setVariable('PROG_FILES32', "%ProgramFiles(x86)%", ['architecture' => "x64"])
    ->setVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", ['os' => "windows xp"])
    ->setVariable('DESKTOP', "%PUBLIC%\Desktop", ['os' => "Windows 7"]);

$config
    ->build()
    ->save();
```

Result of execution:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<config xmlns:profiles="http://www.wpkg.org/config" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/config xsd/config.xsd">
  <param name="wpkg_base" value="http://example.com"/>
  <param name="quitonerror" value="true"/>
  <param name="debug" value="true"/>
  <variables>
    <variable name="PROG_FILES32" value="%ProgramFiles%" architecture="x86"/>
    <variable name="PROG_FILES32" value="%ProgramFiles(x86)%" architecture="x64"/>
    <variable name="DESKTOP" value="%ALLUSERSPROFILE%\Desktop" os="windows xp"/>
    <variable name="DESKTOP" value="%PUBLIC%\Desktop" os="Windows 7"/>
  </variables>
  <languages>
    ... a lot of lines with translations ...
  </languages>
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

Translations tooked from the *config.xml* file that was in the [wpkg-1.3.1-bin.zip](http://wpkg.org/files/stable/1.3.x/wpkg-1.3.1-bin.zip)
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
$_host = new \WPKG\Host();
$_host->wpkg_path = __DIR__ . '/tmp';

$_host->name = 'host1';
$_host->profileId = 'profile1';
// Or you can specify few profiles via array
$_host->profileId = ['profile1', 'profile2', 'profile3']

$_host
    ->build()
    ->save();
```

Result file (with name like <name>.xml, eg host1.xml like in current example) you can find into the **wpkg_path**/hosts/ subfolder:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1"/>
</hosts:wpkg>
```

Or like above, if few profiles:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1">
    <profile id="profile2"/>
    <profile id="profile3"/>
  </host>
</hosts:wpkg>
```

### Hosts.xml file

If you need one large file with all your hosts:

```php
$_hosts = new \WPKG\Hosts();
$_hosts->wpkg_path = __DIR__ . '/tmp';

$host1 = new Host();
$host1->name = 'host1';
$host1->profileId = 'profile1';

$_hosts->set($host1);

$host2 = new Host();
$host2->name = 'host2';
$host2->profileId = ['profile1', 'profile2', 'profile3'];

$_hosts->set($host2);

$_hosts
    ->build()
    ->save();
```

Result file *hosts.xml* into the **wpkg_path** folder

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1"/>
  <host name="host2" profile-id="profile1">
    <profile id="profile2"/>
    <profile id="profile3"/>
  </host>
</hosts:wpkg>
```

### Computers from Active Directory

This class based on [adLdap library](https://github.com/adldap/adLDAP),
so you can use any configuration parameters from this library.

Basic usage:

```php
use \WPKG\AD\Hosts;

$_hosts = new Hosts();
$_hosts->config_adldap = '/path/to/your/adldap.php';
$_hosts->wpkg_path = '/path/to/wpkg';

// Generate the XML tree object by data from AD
$_hosts->build();

// Output the XML
echo $_hosts->show();
```

You should saw something like this:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="test1" profile-id="managers">
    <profile id="dotNet"/>
  </host>
  <host name="test2" profile-id="managers"/>
</hosts:wpkg>
```

If you want save your `hosts.xml` file you need add `save()` command
to your code.

```php
// Save hosts.xml file into the /path/to/wpkg (replace if exist)
$_hosts->save();
```

By default `\WPKG\AD\Hosts` class used configuration from [config](config)
folder of this project, but you can specify path by `config_adldap` class
parameter or set your parameters via `setConfig()` method:

```php
use \WPKG\AD\Hosts;

$_hosts = new Hosts();
$_hosts->setConfig('adldap', ['array' => 'of', 'ldap' => 'parameters']);
$_hosts->wpkg_path = '/path/to/wpkg';
```

## Profiles

Specifies which packages will be installed/executed for each WPKG profile.

### Single profile

If you want generate few profiles in separated files:

```php
$_profile = new \WPKG\Profile();
$_profile->wpkg_path = __DIR__ . '/tmp';

$_profile->id = 'profile1';
$_profile->packages = 'DotNet';
$_profile->depends = 'profile2';

$_profile
    ->build()
    ->save();
```

Result file (with name like <id>.xml, eg profile1.xml like in current example) you can find into the **wpkg_path**/profiles/ subfolder:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<profiles:profiles xmlns:profiles="http://www.wpkg.org/profiles" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/profiles xsd/profiles.xsd">
  <profile id="profile1">
    <depends profile-id="profile2"/>
    <packages package-id="DotNet"/>
  </profile>
</profiles:profiles>
```

### Profiles.xml file

If you need one large file with all your profiles:

```php
$_profiles = new \WPKG\Profiles();
$_profiles->wpkg_path = __DIR__ . '/tmp';

// First profile
$pr1 = new Profile();
$pr1->id = 'profile1';
$pr2->packages = 'DotNet'];

$_profiles->set($pr1);

// Second profile
$pr2 = new Profile();
$pr2->id = 'profile3';
$pr2->packages = ['Firefox', 'Chromium', 'Opera'];
$pr2->depends = 'profile1';

$_profiles->set($pr3);

// Third profile
$pr3 = new Profile();
$pr3->id = 'profile3';
$pr3->packages = ['SuperBank', 'OpenOffice'];
$pr3->depends = ['profile1', 'profile2'];

$_profiles->set($pr2);

$_profiles
    ->build()
    ->save();
```

Result file *profiles.xml* into the **wpkg_path** folder

```xml
<?xml version="1.0" encoding="UTF-8"?>
<profiles:profiles xmlns:profiles="http://www.wpkg.org/profiles" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/profiles xsd/profiles.xsd">
  <profile id="profile1">
    <packages package-id="DotNet"/>
  </profile>
  <profile id="profile2">
    <depends profile-id="profile1"/>
    <packages package-id="Firefox"/>
    <packages package-id="Chromium"/>
    <packages package-id="Opera"/>
  </profile>
  <profile id="profile3">
    <depends profile-id="profile1"/>
    <depends profile-id="profile2"/>
    <packages package-id="SuperBank"/>
    <packages package-id="OpenOffice"/>
  </profile>
</profiles:profiles>
```

## Packages

Defines software packages (commands for WPKG to install/uninstall programs, etc.)

### Single package

If you want generate few packages in separated files:

```php
$_packages = new Package();
$_packages->wpkg_path = __DIR__ . '/tmp';

$_packages->id = 'time';
$_packages->name = 'Time Synchronization';
$_packages->priority = 100;
$_packages->execute = 'always';

$_packages
    ->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages
    ->build()
    ->save();
```

Result file (with name like <id>.xml, eg time.xml like in current example) you can find into the **wpkg_path**/packages/ subfolder:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<packages:packages xmlns:packages="http://www.wpkg.org/packages" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/packages xsd/packages.xsd">
  <package name="Time Synchronization" revision="1" reboot="false" priority="100" execute="always">
    <check type="host" condition="os" path="windows 7"/>
    <commands>
      <command type="install" cmd="net time \timeserver /set /yes"/>
    </commands>
  </package>
</packages:packages>
```

### Packages.xml file

If you need one large file with all your packages:

```php
$_packages = new Packages();
$_packages->wpkg_path = __DIR__ . '/tmp';

// First package
$pk1 = new Package();
$pk1->id = 'time';
$pk1->name = 'Time Synchronization';
$pk1->priority = 100;
$pk1->execute = 'always';
$pk1->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->set($pk1);

// Second package
$pk2 = new Package();
$pk2->id = 'time2';
$pk2->name = 'Time Synchronization';
$pk2->priority = 100;
$pk2->execute = 'always';
$pk2->setCheck('host', 'os', 'windows 7')
    ->setCommand('install', 'net time \\timeserver /set /yes');

$_packages->set($pk2);

$_packages
    ->build()
    ->save();
```

Result file *packages.xml* into the **wpkg_path** folder

# RoadMap

Few tasks what still need realize.

* [ ] Know bugs, issues and not completed tasks
    * [ ] install/remove/uprade aliases for setCommand method of Package class
    * [ ] Multiple choice in checks of Package class
    * [ ] Error message if recipient folder is not exist or not writable
    * [ ] Write tests for all classes
* [x] Generators of configuration files
    * [x] config.xml
    * [x] hosts.xml
    * [x] packages.xml
    * [x] profiles.xml
    * [ ] settings.xml
* [x] Multifiles (in folders) support
    * [x] hosts/
        * [ ] Hosts from Active Directory
    * [x] packages/
    * [x] profiles/
* [ ] Importer
    * [ ] Config
    * [ ] Hosts
    * [ ] Packages
    * [ ] Profiles
    * [ ] Settings
* [ ] XML validator
    * [ ] config.xml
    * [ ] hosts.xml && hosts/
    * [ ] packages.xml && packages/
    * [ ] profiles.xml && profiles/
    * [ ] settings.xml

# Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
* Article on Wikipedia - https://en.wikipedia.org/wiki/WPKG_(software)
