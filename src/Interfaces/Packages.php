<?php namespace WPKG\Interfaces;

interface Packages
{
    /**
     * Add package into the array
     *
     * @param   Package $package
     * @return  Packages
     */
    public function setPackage(Package $package): Packages;

    /**
     * Get package by package-id or all packages
     *
     * @param   string $package_id
     * @return  mixed - Return array of packages or single profile
     */
    public function getPackage(string $package_id = null);

}
