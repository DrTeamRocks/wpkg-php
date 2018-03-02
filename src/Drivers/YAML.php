<?php namespace WPKG\Drivers;

use EvilFreelancer\Yaml\Yaml as YamlFactory;

class YAML
{
    /**
     * @var YamlFactory
     */
    private $yaml;

    public function __construct()
    {
        $this->yaml = new YamlFactory();
    }

    public function build(array $array, string $mode): string
    {
        // Get parameters of current class
        $mode = "WPKG\\Drivers\\YAML\\$mode";
        $source = new $mode();

        // Set root parameter
        $array = [$source::ROOT => $array];

        // Generate YAML
        return $this->yaml->set($array)->show();
    }
}
