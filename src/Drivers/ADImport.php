<?php namespace WPKG\Drivers;

use WPKG\Drivers\AD\Config;
use WPKG\Interfaces\Import;

class ADImport implements Import
{
    /**
     * Load additional methods
     */
    use Config;

    /**
     * ADImport constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) $this->setConfig($config);
    }

    /**
     * Build WPKG object from data stored in AD
     *
     * @param   $mode - Work mode, only Hosts available yet
     * @return  mixed
     */
    public function import($mode)
    {
        // Small fix of workmode
        $mode = ucfirst(strtolower($mode));

        // Choose the driver's mode for work
        $class = "\\WPKG\\Drivers\\AD\\$mode";
        $class = new $class($this->getConfig());

        // Import values
        return $class->import();
    }
}
