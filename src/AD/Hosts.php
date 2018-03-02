<?php namespace WPKG\AD\Classes;

use \Adldap\Adldap;
use \Adldap\AdldapException;

class Hosts extends \WPKG\Hosts implements \WPKG\Interfaces\Hosts
{
    /**
     * Add some ldap methods from trait class
     */
    use LDAP;

    /**
     * @var Adldap
     */
    private $_adldap;

    /**
     * Path to adLdap config
     * @var string
     */
    public $config_adldap;

    /**
     * Array with configs
     * @var array
     */
    private $_config = [];

    /**
     * Enable multi files support
     * @var bool
     */
    private $_multi_files = false;

    /**
     * Importer constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    private function connect()
    {
        // If configuration is not set already
        if (!isset($this->_config['adldap'])) {
            // Read config from file
            $adldap = isset($this->config_adldap)
                ? require_once $this->config_adldap
                : die("Error: adldap config is not set\n");

            // Then read configuration from parameter or from default path
            $this->setConfig('adldap', $adldap);
        }

        try {
            // If connection is empty
            if (empty($this->_adldap)) {
                // Create adLDAP object by parameters from config
                $this->_adldap = new Adldap($this->_config['adldap']);
            }
            // Get computers from LDAP
            $this->loadComputers();
        } catch (AdldapException $e) {
            die($e);
        }
    }

    /**
     * Set the configuration
     * @param string $name
     * @param string|array $parameters
     */
    public function setConfig(string $name, $parameters)
    {
        $this->_config[$name] = $parameters;
    }

    /**
     * Get the config by name
     * @param $name
     * @return string|array
     */
    public function getConfig(string $name)
    {
        return $this->_config[$name];
    }

    /**
     * @param bool $multi - Multiple files mode
     * @return object|array
     */
    public function build(bool $multi = false)
    {
        // Set mode
        $this->_multi_files = $multi;
        // Open connection with server
        $this->connect();

        // Read hosts array and build the XML tree
        foreach ($this->_hosts as $host) {
            $this->append($this->_xml, $host->build(true)->_xml);
        }
        return $this;
    }

}
