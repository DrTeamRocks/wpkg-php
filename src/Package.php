<?php namespace WPKG;

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
            Exceptions::arrayKeyAllowed($key, Package::KEYS);

            // Add value into the array
            $this->_packages['package'][0][$key] = $value;

        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

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
                Exceptions::arrayKeyAllowed($key, Package::KEYS);
                Exceptions::arrayKeyDefined($key, $this->_packages['package'][0]);

                // Return value from array
                $result = $this->_packages['package'][0][$key];
            } else {
                // Return all values from array
                $result = $this->_packages['package'][0];
            }
        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $result;
    }

    /**
     * Set some variable
     *
     * @param   string $name
     * @param   string $value
     * @return  \WPKG\Interfaces\Package
     */
    public function withVariable(string $name, string $value): Interfaces\Package
    {
        $this->_packages['package'][0]['variables'][$name] = $value;
        return $this;
    }

    /**
     * Get some variable or array of variables
     *
     * @param   string $name - Name of required variable
     * @return  array|string
     */
    public function getVariable(string $name = null)
    {
        return empty($name)
            ? $this->_packages['package'][0]['variables']
            : $this->_packages['package'][0]['variables'][$name];
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
        $array = ['type' => $type];
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
     * @return  \WPKG\Interfaces\Package
     */
    public function withCheck(string $type, string $condition, string $path): Interfaces\Package
    {
        $this->_packages['package'][0]['checks'][$type][] = [
            'condition' => $condition,
            'path' => $path
        ];

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

}
