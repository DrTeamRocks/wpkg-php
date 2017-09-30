# WPKG config generator on PHP

Prototype of library for generating of configs for WPKG project.

## Examples

Full examples with descriptions you can find [here](/extra).

### How to create *hosts.xml* file

Here the small example should showing you how to generate hosts.xml file.

```php
$hosts = new \WPKG\Hosts();
$hosts->path = '/path/to/wpkg';

$hosts
    ->add('host1', 'profile1')
    ->add('host2', ['profile1', 'profile2', 'profile3'])
    ->add('host3', 'profile3')
    ->build()
    ->save();
```

### How to create *profiles.xml* file

Here the small example should showing you how to generate hosts.xml file.

```php
$hosts = new \WPKG\Hosts();
$hosts->path = '/path/to/wpkg';

$hosts
    ->add('profile1', 'DotNet')
    ->add('profile2', ['Firefox', 'Chromium', 'Opera'], 'profile1')
    ->add('profile3', ['SuperBank', 'AnotherBank'], ['profile1', 'profile2'])
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
    * [x] packages.xml
    * [ ] profiles.xml
* [ ] Write tests for all classes

## Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
