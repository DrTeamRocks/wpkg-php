<?php namespace WPKG;

/**
 * Class for work with Packages.xml file
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Packages
 */
class Packages extends WPKG implements Interfaces\Packages
{
    /**
     * Array of packages
     * @var array
     */
    protected $_packages = [];

    /**
     * Add package into the array
     *
     * @param   \WPKG\Interfaces\Package $package
     * @return  \WPKG\Interfaces\Packages
     */
    public function setPackage(Interfaces\Package $package): Interfaces\Packages
    {
        // Store package object
        $this->_packages[] = $package->getCurrent();
        return $this;
    }

    /**
     * Get package by package-id or all packages
     *
     * @param   string $package_id
     * @return  mixed - Return array of packages or single profile
     */
    public function getPackage(string $package_id = null)
    {
        return !empty($package_id)
            ? array_search(['id' => $package_id], $this->_packages)
            : $this->_packages;
    }

    /**
     * Show document in required format
     *
     * @param   string $mode
     * @return  bool|string
     */
    public function show(string $mode = 'xml')
    {
        return $this->build($this->_packages, $mode, 'Packages');
    }

}
