# WPKG XML configuration generator, created in PHP language

Prototype of library for generating of configs for WPKG project.
Check [links](#some-links) for more info about WPKG.

## Examples

Full examples with descriptions you can find [here](/extra).

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

### How to create *profiles.xml* file

For hosts need profiles, here you can see how to generate it.

```php
$hosts = new \WPKG\Hosts();
$hosts->path = '/path/to/wpkg';

$hosts
    ->set('profile1', 'DotNet')
    ->set('profile2', ['Firefox', 'Chromium', 'Opera'], 'profile1')
    ->set('profile3', ['SuperBank', 'AnotherBank'], ['profile1', 'profile2'])
    ->build()
    ->save();
```

## RoadMap

Few tasks what still need realize.

* [ ] Global
    * [ ] Multifiles (in folders) support
    * [ ] XML files reading and parsing into the class parameters
* [ ] Basic version of generators for
    * [ ] config.xml
    * [x] hosts.xml
    * [ ] packages.xml
    * [x] profiles.xml
* [ ] Write tests for all classes

## Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
* Article on Wikipedia - https://en.wikipedia.org/wiki/WPKG_(software)
