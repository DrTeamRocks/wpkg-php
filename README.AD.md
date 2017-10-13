# WPKG hosts.xml generator by data from Active Directory

For normal work of this script you just need create user with
Administrator rights (not local Administrator, is important!).

    composer require wpkg\wpkg-php-ad

This project based on [adLdap library](https://github.com/adldap/adLDAP),
so you can use any configuration parameters of this library.

## How to use

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

## RoadMap

* [ ] Multifiles support
* [ ] Tests
