<?php namespace WPKG\Interfaces;

interface PackageCheckExits
{
    /**
     * Return array with all checks
     *
     * @return  array
     */
    public function get(): array;

    /**
     * Add some parameter of check
     *
     * @param   string $code
     * @param   bool|null $reboot
     * @return  \WPKG\Interfaces\PackageCheckExits
     */
    public function add(string $code, bool $reboot = null): PackageCheckExits;

}
