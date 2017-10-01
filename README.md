# WPKG XML configuration generator

Prototype of library for generating of configs for WPKG project.
Check [links](#some-links) for more info about WPKG.

## Table of Contents

- [Examples](#examples)
    - [How to create config.xml file](#how-to-create-config.xml-file)
- [Roadmap](#roadmap)
- [Some links](#some-links)

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
$config->wpkg_path = '/path/to/wpkg';

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

## RoadMap

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

## Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
* Article on Wikipedia - https://en.wikipedia.org/wiki/WPKG_(software)
