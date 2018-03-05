<?php namespace WPKG;

class WPKG
{
    /**
     * List of available types of result
     */
    const TYPES = ['xml', 'yaml', 'json'];

    /**
     * Convert array to config
     *
     * @param   array $array - Data collection for config
     * @param   string $type - Type of result
     * @param   string $mode - Work mode
     * @return  mixed
     */
    public function build(array $array, string $type = 'xml', string $mode)
    {
        // To lowercase
        $type = strtolower($type);

        try {
            // Check parameters
            Exceptions::arrayKeyAllowed($type, self::TYPES);

            // To uppercase
            $type = strtoupper($type);

            // Create class for work
            $driver = "\\WPKG\\Drivers\\$type";
            $factory = new $driver();

            // Check for object
            Exceptions::isObject($factory);

        } catch (\Exception $e) {
            die("Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n");
        }

        // Convert all boolean variables to text
        array_walk_recursive($array, function (&$value) {
            if (is_bool($value)) {
                $value = $this->bool2text($value);
            }
        });

        // Return object
        return $factory->build($array, $mode);
    }

    /**
     * Small method for converting boolean variables to text equivalent
     *
     * @param   bool $bool - true|false|0|1
     * @return  string
     */
    protected function bool2text(bool $bool): string
    {
        return $bool ? 'true' : 'false';
    }
}
