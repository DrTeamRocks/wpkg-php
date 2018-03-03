<?php namespace WPKG;

/**
 * Class for work with Packages/ folder
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG
 */
class PackageCheckExits implements Interfaces\PackageCheckExits
{
    /**
     * @var array
     */
    private $_exits = [];

    /**
     * Return array with all exits
     *
     * @return  array
     */
    public function get(): array
    {
        return $this->_exits;
    }

    /**
     * Add some parameter of exits
     *
     * @param   string $code
     * @param   bool|null $reboot
     * @return  \WPKG\Interfaces\PackageCheckExits
     */
    public function add(string $code, bool $reboot = null): Interfaces\PackageCheckExits
    {
        $array = ['code' => $code];
        if (!empty($reboot)) $array['reboot'] = $reboot;

        // Add value into the array
        $this->_exits[] = $array;

        return $this;
    }

}
