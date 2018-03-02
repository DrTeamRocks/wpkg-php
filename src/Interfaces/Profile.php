<?php namespace WPKG\Interfaces;

interface Profile
{
    /**
     * Name of profile
     */
    const ID = 'id';

    /**
     * Dependencies of current profile
     */
    const DEPENDS = 'depends';

    /**
     * Packages which should be installed
     */
    const PACKAGES = 'packages';

    /**
     * Get current profile
     *
     * @return  array
     */
    public function getCurrent(): array;

    /**
     * Get value of some specific key or of all keys from current profile
     *
     * @param   string|null $key - Key name
     * @return  mixed
     */
    public function getParam(string $key = null);

    /**
     * Add (replace if exist) some parameter of current profile
     *
     * @param   string $key - Key name
     * @param   mixed $value - Any value it can be string, number or array
     * @return  \WPKG\Interfaces\Profile
     */
    public function with(string $key, $value): Profile;
}
