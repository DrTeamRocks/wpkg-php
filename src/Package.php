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
     * List of keys available by default
     * @var array
     */
    private $_keys = [
        Package::ID,
        Package::NAME,
        Package::REVISION,
        Package::REBOOT,
        Package::PRIORITY,
        Package::EXECUTE
    ];

    /**
     * Get current object
     *
     * @return  array
     */
    public function getCurrent(): array
    {
        return $this->_packages[0];
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
            Exceptions::arrayKeyAllowed($key, $this->_keys);

            // Add value into the array
            $this->_packages[0][$key] = $value;

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
                Exceptions::arrayKeyAllowed($key, $this->_keys);
                Exceptions::arrayKeyDefined($key, $this->_packages[0]);

                // Return value from array
                $result = $this->_packages[0][$key];
            } else {
                // Return all values from array
                $result = $this->_packages[0];
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
    public function setVariable(string $name, string $value): Interfaces\Package
    {
        $this->_packages[0]['variables'][$name] = $value;
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
            ? $this->_packages[0]['variables']
            : $this->_packages[0]['variables'][$name];
    }

    /**
     * Set the command of package
     *
     * @param   string $type
     * @param   string $cmd
     * @param   string|array|null $include
     * @param   array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return  \WPKG\Interfaces\Package
     */
    public function setCommand(string $type, string $cmd, $include = null, array $exit = []): Interfaces\Package
    {
        $this->_packages[0]['commands'][$type][] = [
            'cmd' => $cmd,
            'include' => $include,
            'exit' => $exit
        ];

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
            ? $this->_packages[0]['commands']
            : $this->_packages[0]['commands'][$type];
    }

    /**
     * Add some important check into array
     *
     * @param   string $type
     * @param   string $condition
     * @param   string $path
     * @return  \WPKG\Interfaces\Package
     */
    public function setCheck(string $type, string $condition, string $path): Interfaces\Package
    {
        $this->_packages[0]['checks'][$type][] = [
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
            ? $this->_packages[0]['checks']
            : $this->_packages[0]['checks'][$type];
    }

}
