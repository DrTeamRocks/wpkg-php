<?php namespace WPKG\Interfaces\Hosts;

use \WPKG\Classes\Hosts\Host;

interface Hosts
{
    /**
     * Add new host into the list
     *
     * @param Host $host
     * @return object
     */
    public function set(Host $host);

    /**
     * Get array of hosts or single host by name
     *
     * @param string|null $name - Hostname
     * @return array|string
     */
    public function get(string $name = null);

    /**
     * Generate XML tree by data in memory
     *
     * @return string
     */
    public function build();
}
