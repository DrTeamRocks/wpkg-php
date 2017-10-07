<?php namespace WPKG\Classes\Packages;

use WPKG\Interfaces\Packages\Package;

/**
 * Class for work with Packages.xml file
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Packages
 */
class Packages extends XMLOptions implements \WPKG\Interfaces\Packages\Packages
{
    /**
     * Name of file on filesystem
     * @var string
     */
    public $_filename = 'packages.xml';

    /**
     * Array of packages
     * @var array
     */
    private $_packages = [];

    /**
     * Add package into the array
     *
     * @param Package $package
     * @return object
     */
    public function set(Package $package)
    {
        // Store package object
        $this->_packages[$package->id] = $package;
        return $this;
    }

    /**
     * Get package by package-id or all packages
     *
     * @param string $id
     * @return array|Package - Return array of packages or single profile
     */
    public function get(string $id = null)
    {
        return !empty($id) ? $this->_packages[$id] : $this->_packages;
    }

    /**
     * Build the packages.xml
     *
     * @return object
     */
    public function build()
    {
        // Read packages array and build the XML tree
        foreach ($this->_packages as $package) {
            $this->append($this->_xml, $package->build(true)->_xml);
        }
        return $this;
    }
}
