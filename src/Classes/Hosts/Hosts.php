<?php namespace WPKG\Classes\Hosts;

/**
 * Class for work with Hosts.xml file or Hosts/ folder
 *
 * @link https://wpkg.org/Hosts.xml
 * @package WPKG\Classes\Hosts
 */
class Hosts extends XMLOptions implements \WPKG\Interfaces\Hosts\Hosts
{
    /**
     * Name of file on filesystem
     * @var string
     */
    protected $_filename = 'hosts.xml';

    /**
     * Array of hosts
     * @var array
     */
    protected $_hosts;

    /**
     * Add new host into the list
     *
     * @param Host $host
     * @return object
     */
    public function set(Host $host)
    {
        // Store host object to array
        $this->_hosts[$host->name] = $host;
        return $this;
    }

    /**
     * Get array of hosts or single host
     *
     * @param string|null $hostname
     * @return array|string
     */
    public function get(string $hostname = null)
    {
        return !empty($hostname) ? $this->_hosts[$hostname] : $this->_hosts;
    }

    /**
     * Generate XML by data in memory
     *
     * @return object
     */
    public function build()
    {
        // Read hosts array and build the XML tree
        foreach ($this->_hosts as $host) {
            $this->append($this->_xml, $host->build(true)->_xml);
        }
        return $this;
    }

}
