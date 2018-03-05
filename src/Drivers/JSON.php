<?php namespace WPKG\Drivers;

use \WPKG\Interfaces\Export;

class JSON implements Export
{
    /**
     * Build configuration file from data in array
     *
     * @param   array $array - Incoming array for convert
     * @param   string $mode - Work mode, Hosts, Packages etc
     * @return  string
     */
    public function build(array $array, string $mode): string
    {
        // Set root parameter
        $array = [strtolower($mode) => $array];

        // Create valid JSON object
        return json_encode($array);
    }
}
