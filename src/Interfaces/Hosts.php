<?php namespace WPKG\Interfaces;

interface Hosts
{
    /**
     * Add new host into the list
     *
     * @param Host $host
     * @return object
     */
    public function setHost(Host $host);

    /**
     * Get array of hosts or single host by name
     *
     * @param string|null $name - Hostname
     * @return array|string
     */
    public function getHost(string $name = null);
}
