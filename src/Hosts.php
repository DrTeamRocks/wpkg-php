<?php namespace WPKG;

/**
 * Class for work with Hosts.xml file or Hosts/ folder
 *
 * @link https://wpkg.org/Hosts.xml
 * @package WPKG
 */
class Hosts extends WPKG implements Interfaces\Hosts
{
    /**
     * Array of hosts
     * @var array
     */
    protected $_hosts;

    /**
     * Add new host into the list
     *
     * @param   \WPKG\Interfaces\Host $host
     * @return  $this
     */
    public function setHost(Interfaces\Host $host)
    {
        // Store host object to array
        $this->_hosts['host'][] = $host->getCurrent();
        return $this;
    }

    /**
     * Get array of hosts or single host
     *
     * @param string|null $hostname
     * @return array|Host - Return array of hosts or single host
     */
    public function getHost(string $hostname = null)
    {
        return !empty($hostname)
            ? array_search(['name' => $hostname], $this->_hosts['host'])
            : $this->_hosts;
    }

    /**
     * Show document in required format
     *
     * @param   string $mode
     * @return  bool|string
     */
    public function show(string $mode = 'xml')
    {
        return $this->build($this->_hosts, $mode, 'Hosts');
    }
}
