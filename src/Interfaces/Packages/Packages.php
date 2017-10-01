<?php namespace WPKG\Interfaces\Packages;

interface Packages
{
    /**
     * Add package into the array
     *
     * @param Package $package
     * @return object
     */
    public function set(Package $package);

    /**
     * Get package by package-id or all packages
     *
     * @param string $id
     * @return array
     */
    public function get(string $id = null);

    /**
     * Build the packages.xml
     *
     * @return object
     */
    public function build();
}
