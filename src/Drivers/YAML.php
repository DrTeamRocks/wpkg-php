<?php namespace WPKG\Drivers;

use \WPKG\Interfaces\Export;

class YAML implements Export
{
    public function build(array $array, string $mode): string
    {
        // Get parameters of current class
        $mode = "WPKG\\Drivers\\YAML\\$mode";
        $source = new $mode();

        // Set root parameter
        $array = [$source::ROOT => $array];

        // Create object of YAML driver
        $yaml = new \EvilFreelancer\Yaml\Yaml();

        // Generate YAML
        return $yaml->set($array)->show();
    }
}
