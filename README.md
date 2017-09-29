# WPKG config generator on PHP

Prototype of library for generating of configs for WPKG project.

## How to create *hosts.xml* file

Here the small example should showing you how to generate hosts.xml file.

```php
$hosts = new \WPKG\Hosts();
$hosts->path = '/path/to/wpkg';

$hosts->add('host1', 'custom');
$hosts->add('host2', ['one', 'two', 'three']);
$hosts->add('host3', 'another');

$hosts->build();
$hosts->save();
```

You can also use single line method:

```php
$hosts = new \WPKG\Hosts();
$hosts->path = '/path/to/wpkg';

$hosts
    ->add('host1', 'custom')
    ->add('host2', ['one', 'two', 'three'])
    ->add('host3', 'another')
    ->build()
    ->save();
```

Any other examples you can find [here](/extra).

## RoadMap

Few tasks what still need realize.

* [ ] Global
    * [ ] Multifiles (in folders) support
    * [ ] XML files reading and parsing into the class parameters
* [ ] Basic version of generators for
    * [ ] config.xml
    * [x] hosts.xml
    * [ ] packages.xml
    * [ ] profiles.xml

## Some links

* Main the WPKG website - https://wpkg.org/
* WPKG documentation page - https://wpkg.org/Documentation
