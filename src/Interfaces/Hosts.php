<?php namespace WPKG\Interfaces;

interface Hosts
{
    /**
     * Generate the XML input data
     *
     * @param string $hostname
     * @param string|array $profile
     * @return object
     */
    public function add(string $hostname, $profile);

    /**
     * Get array of hosts or single host
     *
     * @param string|null $hostname
     * @return array|string
     */
    public function get(string $hostname = null);

    /**
     * Generate XML by data in memory
     *
     * @return string
     */
    public function build();

    /**
     * Generate the array from XML file
     *
     * @return object
     */
    public function read();

    /**
     * Show current view of XML file
     *
     * @return mixed
     */
    public function show();

    /**
     * Save the file on filesystem
     *
     * @return bool
     */
    public function save();
}
