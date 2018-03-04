<?php namespace WPKG\Drivers\AD;

use \WPKG\Host;

class Hosts extends \WPKG\Hosts implements \WPKG\Interfaces\Hosts
{
    /**
     * Load additional methods
     */
    use Config, AD;

    /**
     * A list of computers
     * @var array
     */
    private $_adldap_hosts;

    /**
     * Hosts constructor.
     *
     * @param   array $config
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->setConfig($config);
        }
    }

    /**
     * Import computers from Active Directory
     *
     * @return  $this
     * @throws  \Exception
     */

    public function import()
    {
        // Connect to AD server
        if (empty($this->_adldap)) $this->connect();

        // Get computers from LDAP
        $this->_adldap_hosts = $this->_adldap->search()->computers()->get();

        // Set computer to list
        foreach ($this->_adldap_hosts as $computer) {
            // Get all groups of this computer
            //$groups = $computer->memberOf();

            // Let's create new host object
            $host = new Host();
            $host
                ->with('name', $computer->getDnsHostName())
                ->with('profile-id', 'default');

            // Add host to list
            $this->setHost($host);
        }
        return $this;
    }

}
