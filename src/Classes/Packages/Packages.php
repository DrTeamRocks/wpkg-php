<?php namespace WPKG\Classes\Packages;

use WPKG\Interfaces\Package;

/**
 * Class for work with Packages.xml file
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Packages
 */
class Packages extends XMLOptions implements \WPKG\Interfaces\Packages
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
     * @return array
     */
    public function get(string $id = null)
    {
        return !empty($id) ? $this->_packages[$id] : $this->_packages;
    }

    /**
     * Merge two XML trees
     *
     * @param $parent
     * @param $child
     */
    private function append(&$parent, &$child)
    {
        // Create new DOMElements from the two SimpleXMLElements
        $dom1 = dom_import_simplexml($parent);
        $dom2 = dom_import_simplexml($child);
        // Import the  into the  document
        $dom2 = $dom1->ownerDocument->importNode($dom2, TRUE);
        // Append the  to
        $dom1->appendChild($dom2);
    }

    /**
     * Build the packages.xml
     *
     * @return object
     */
    public function build()
    {
        //$this->_xml
        foreach ($this->_packages as $package) {
            $this->append($this->_xml, $package->build()->_xml);
        }
        return $this;
    }
}
