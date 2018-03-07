<?php namespace WPKG;

use WPKG\Exceptions\ArrayException;

/**
 * Class for work with Packages/ folder
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG
 */
class Package extends Packages implements Interfaces\Package
{
    /**
     * Get current object
     *
     * @return  array
     */
    public function getCurrent(): array
    {
        return $this->_packages['package'][0];
    }

    /**
     * Add some parameter of package
     *
     * @param   string $key
     * @param   mixed $value
     * @return  \WPKG\Interfaces\Package
     */
    public function with(string $key, $value): Interfaces\Package
    {
        try {
            // Check parameters
            ArrayException::keyAllowed($key, Package::KEYS);

            // Add value into the array
            $this->_packages['package'][0][$key] = $value;

        } catch (ArrayException $e) {}

        return $this;
    }

    /**
     * Get parameter by keyname or all if key is not set
     *
     * @param   string|null $key
     * @return  mixed
     */
    public function getParam(string $key = null)
    {
        // Default result
        $result = false;

        try {
            if (!empty($key)) {
                // Check parameters
                ArrayException::keyAllowed($key, Package::KEYS);
                ArrayException::keyDefined($key, $this->_packages['package'][0]);

                // Return value from array
                $result = $this->_packages['package'][0][$key];
            } else {
                // Return all values from array
                $result = $this->_packages['package'][0];
            }
        } catch (ArrayException $e) {}

        return $result;
    }

    /**
     * Append variable into array of config's variables
     *
     * @param   string $name
     * @param   string $value
     * @param   null|string $os - Operation system name ['Windows xp','Windows 7'...]
     * @param   null|string $arch - Architecture of processor ['x86', 'x64'...]
     * @return  \WPKG\Interfaces\Package
     */
    public function withVariable(string $name, string $value, string $os = null, string $arch = null): Interfaces\Package
    {
        $array = [
            'name' => $name,
            'value' => $value
        ];

        if (!empty($os)) $array['os'] = $os;
        if (!empty($arch)) $array['architecture'] = $arch;

        $this->_packages['package'][0]['variables'][] = $array;
        return $this;
    }

    /**
     * Get array of variables
     *
     * @return  array|string
     */
    public function getVariables(): array
    {
        return $this->_packages['package'][0]['variables'];
    }

    /**
     * Set the command of package
     *
     * @param   string $type
     * @param   string|null $cmd
     * @param   mixed $include
     * @param   null|\WPKG\Interfaces\PackageCheckExits $exits - List of exit codes, look at \WPKG\PackageCheckExits class for this
     * @return  \WPKG\Interfaces\Package
     */
    public function withCommand(string $type, string $cmd = null, $include = null, Interfaces\PackageCheckExits $exits = null): Interfaces\Package
    {
        $array = [];
        if (!empty($cmd)) $array['cmd'] = $cmd;
        if (!empty($include)) $array['include'] = $include;
        if (!empty($exits)) $array['exits'] = $exits->get();

        $this->_packages['package'][0]['commands'][$type][] = $array;

        return $this;
    }

    /**
     * Get all commands or single command for current package
     *
     * @param   string|null $type
     * @return  array
     */
    public function getCommand(string $type = null): array
    {
        return empty($type)
            ? $this->_packages['package'][0]['commands']
            : $this->_packages['package'][0]['commands'][$type];
    }

    /**
     * Add some important check into array
     *
     * @param   string $type
     * @param   string $condition
     * @param   string $path
     * @param   string $value
     * @return  \WPKG\Interfaces\Package
     */
    public function withCheck(string $type, string $condition, string $path, string $value = null): Interfaces\Package
    {
        $array = [
            'condition' => $condition,
            'path' => $path
        ];

        // Value may be not set
        if (!empty($value)) $array['value'] = $value;

        // Put new check into checks of current package
        $this->_packages['package'][0]['checks'][$type][] = $array;

        return $this;
    }

    /**
     * Get all checks or checks by some specific type
     *
     * @param   string|null $type
     * @return  array
     */
    public function getCheck(string $type = null): array
    {
        return empty($type)
            ? $this->_packages['package'][0]['checks']
            : $this->_packages['package'][0]['checks'][$type];
    }

    /**
     * Add includes of current package
     *
     * @param   string $include
     * @return  \WPKG\Interfaces\Package
     */
    public function withInclude(string $include): Interfaces\Package
    {
        $this->_packages['include'][] = $include;
        return $this;
    }

    /**
     * Take a list of includes
     *
     * @return  array
     */
    public function getInclude(): array
    {
        return $this->_packages['include'];
    }

}
