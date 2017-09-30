<?php namespace WPKG\Interfaces;

interface Profiles
{
    /**
     * Add new profile into the list
     *
     * @param string $profile
     * @param array|string|null $depends
     * @param array|string|null $packages
     * @return mixed
     */
    public function set(string $profile, $depends = null, $packages = null);

    /**
     * Get array of profiles or single profile
     *
     * @param string|null $profile
     * @return array|string
     */
    public function get(string $profile = null);

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
    public function show();
}
