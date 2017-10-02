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
        - [Hosts.xml file](#hostsxml-file)
        - [Single host](#single-host)
    - [Packages](#packages)
        - [Packages.xml file](#packagesxml-file)
        - [Single package](#single-package)
    - [Profiles](#packages)
        - [Profiles.xml file](#profilesxml-file)
        - [Single profile](#single-profile)
- [RoadMap](#roadmap)
- [Some links](#some-links)

# Simple how to

Almost all classes have several identical methods:

* build() - Execute the XML tree generation
* show() - Print to STDOUT generated XML
* save() - Create (replace if exist) new file on filesystem


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

$config->setVariable('PROG_FILES32', "%ProgramFiles%", ['architecture' => "x86"]);
$config->setVariable('PROG_FILES32', "%ProgramFiles(x86)%", ['architecture' => "x64"]);
$config->setVariable('DESKTOP', "%ALLUSERSPROFILE%\Desktop", ['os' => "windows xp"]);
$config->setVariable('DESKTOP', "%PUBLIC%\Desktop", ['os' => "Windows 7"]);

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

Result file *config.xml* into the **wpkg_path** folder

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

# RoadMap

Few tasks what still need realize.

* [ ] Know NOT completed tasks
    * [ ] Multiple choice in checks of package
    * [ ] Error message if recipient folder is not exist or not writable
* [x] Generators of configuration files
    * [x] config.xml
    * [x] hosts.xml
    * [x] packages.xml
    * [x] profiles.xml
* [x] Multifiles (in folders) support
    * [x] hosts/
    * [x] packages/
    * [x] profiles/
* [ ] Importer
    * [ ] Config
    * [ ] Hosts
    * [ ] Packages
    * [ ] Profiles
* [ ] XML validator
    * [ ] config.xml
    * [ ] hosts.xml && hosts/
    * [ ] packages.xml && packages/
    * [ ] profiles.xml && profiles/
* [ ] Write tests for all classes
    * [ ] Here a lot of classes

# Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
* Article on Wikipedia - https://en.wikipedia.org/wiki/WPKG_(software)
