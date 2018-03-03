<?php namespace WPKG\Interfaces;

interface Host
{
    /**
     * List of keys available by default
     */
    const KEYS = [
        Host::NAME,
        Host::PROFILE_ID
    ];

    /**
     * Name of current host
     */
    const NAME = 'name';

    /**
     * Store the single profile of host or multiple profiles
     */
    const PROFILE_ID = 'profile-id';

    /**
     * Get current host
     * @return  array
     */
    public function getCurrent(): array;

    /**
     * Get value of some specific key or of all keys from current host
     *
     * @param   string|null $key - Key name
     * @return  mixed
     */
    public function getParam(string $key = null);

    /**
     * Add (replace if exist) some parameter of current host
     *
     * @param   string $key - Key name
     * @param   mixed $value - Any value it can be string, number or array
     * @return  \WPKG\Interfaces\Host
     */
    public function with(string $key, $value): Host;

}
