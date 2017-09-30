# WPKG XML configuration generator

Prototype of library for generating of configs for WPKG project.
Check [links](#some-links) for more info about WPKG.

## Examples

Any other examples with descriptions you can find [here](/extra).

    Note: Don't forget execute "build()" method before "show()" or "save()".

### How to create *config.xml* file

Using the Config class, you can override the settings, if you specified
a value different from the default value, your parameter will be added
to the XML file.

If you do not specify anything, a configuration with default parameters
will be generated.

```php
$config = new \WPKG\Config();
$config->path = '/path/to/wpkg';

$config->wpkg_base = 'http://example.com';
$config->quitonerror = true;
$config->debug = true;

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
  <variables/>
  <languages>
    ... a lot of lines with translations ...
  </languages>
</config>
```

### How to create *hosts.xml* file

Here the small example should showing you how to generate hosts.xml file.

```php
$hosts = new \WPKG\Hosts();
$hosts->path = '/path/to/wpkg';

$hosts
    ->set('host1', 'profile1')
    ->set('host2', ['profile1', 'profile2', 'profile3'])
    ->set('host3', 'profile3')
    ->build()
    ->save();
```

Result of execution:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<hosts:wpkg xmlns:hosts="http://www.wpkg.org/hosts" xmlns:wpkg="http://www.wpkg.org/wpkg" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.wpkg.org/hosts xsd/hosts.xsd">
  <host name="host1" profile-id="profile1"/>
  <host name="host2" profile-id="profile1">
    <profile id="profile2"/>
    <profile id="profile3"/>
  </host>
  <host name="host3" profile-id="profile3"/>
</hosts:wpkg>
```

### How to create *profiles.xml* file

For hosts need profiles, here you can see how to generate it.

```php
$profiles = new \WPKG\Profiles();
$profiles->path = '/path/to/wpkg';

$profiles
    ->set('profile1', 'DotNet')
    ->set('profile2', ['Firefox', 'Chromium', 'Opera'], 'profile1')
    ->set('profile3', ['SuperBank', 'AnotherBank'], ['profile1', 'profile2'])
    ->build()
    ->save();
```

Result of execution:

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
    <packages package-id="AnotherBank"/>
  </profile>
</profiles:profiles>
```

## RoadMap

Few tasks what still need realize.

* [ ] Generators of configuration files
    * [x] config.xml
    * [x] hosts.xml
    * [ ] packages.xml
    * [x] profiles.xml
* [ ] Multifiles (in folders) support
* [ ] XML files reading and parsing into the class parameters
* [ ] Write tests for all classes
* [ ] XML validator

## Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
* Article on Wikipedia - https://en.wikipedia.org/wiki/WPKG_(software)
