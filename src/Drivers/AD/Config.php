<?php namespace WPKG\Drivers\AD;

trait Config
{
    /**
     * Array with configuration
     * @var array
     */
    private $_config = [];

    /**
     * Install configuration file
     *
     * @param   array $config
     */
    public function setConfig(array $config)
    {
        $this->_config = $config;
    }

    /**
     * Get whole config or single parameter by name
     *
     * @param   string|null $name - Name of parameter which should be returned
     * @return  string|array
     */
    public function getConfig(string $name = null)
    {
        return empty($name)
            ? $this->_config
            : $this->_config[$name];
    }
}