<?php namespace WPKG\Interfaces;

interface Profiles
{
    /**
     * Add new profile into the list
     *
     * @param Profile $profile
     * @return object
     */
    public function set(Profile $profile);

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
}
