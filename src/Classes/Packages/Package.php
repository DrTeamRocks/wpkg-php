<?php namespace WPKG\Classes\Packages;

/**
 * Class for work with Packages/ folder
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Packages
 */
class Package extends XMLOptions implements \WPKG\Interfaces\Package
{
    /**
     * Short name of package (used as filename, must be unique)
     * @var string
     */
    public $id = 'example';

    /**
     * Long name of package
     * @var string
     */
    public $name = 'Example Package';

    /**
     * Numeric version of revision, need for upgrade event
     * @var int
     */
    public $revision = 1;

    /**
     * Reboot after install, upgrade or remove of package
     * @var bool
     */
    public $reboot = false;

    /**
     * Priority of package
     * @var int
     */
    public $priority = 0;

    /**
     * Execution period (optional)
     * @var string
     */
    public $execute = null;

    /**
     * Parameters for checks
     * @var array
     */
    protected $_checks = [];

    /**
     * List of commands
     * @var array
     */
    protected $_commands = [];

    /**
     * List of variables
     * @var array
     */
    protected $_variables = [];

    /**
     * Set some variable
     *
     * @param   string $name
     * @param   string $value
     * @return  \WPKG\Interfaces\Package
     */
    public function setVariable(string $name, string $value): \WPKG\Interfaces\Package
    {
        $this->_variables[$name] = $value;
        return $this;
    }

    /**
     * Get some variable or array of variables
     *
     * @param   string $name - Name of required variable
     * @return  array|string
     */
    public function getVariables(string $name = null)
    {
        return empty($name) ? $this->_variables : $this->_variables[$name];
    }

    /**
     * Set the command of package
     *
     * @param   string $type
     * @param   string $cmd
     * @param   string|array|null $include
     * @param   array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return  Package
     */
    public function setCommand(string $type, string $cmd, $include = null, array $exit = []): \WPKG\Interfaces\Package
    {
        $this->_commands[$type][] = [
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
    public function getCommands(string $type = null): array
    {
        return empty($type) ? $this->_commands : $this->_commands[$type];
    }

    /**
     * Setter of check value
     *
     * @param   string $type
     * @param   string $condition
     * @param   string $path
     * @return  \WPKG\Interfaces\Package
     */
    public function setCheck(string $type, string $condition, string $path): \WPKG\Interfaces\Package
    {
        $this->_checks[$type][] = [
            'condition' => $condition,
            'path' => $path
        ];

        return $this;
    }

    /**
     * Getter of checks
     *
     * @param   string|null $type
     * @return  array
     */
    public function getChecks(string $type = null): array
    {
        return empty($type) ? $this->_checks : $this->_checks[$type];
    }

    /**
     * Generate XML tree by data in memory
     *
     * @param   bool $multi - Multiple files mode
     * @return  \WPKG\Interfaces\Package
     */
    public function build(bool $multi = false): \WPKG\Interfaces\Package
    {
        // If multiple files mode enabled
        (true === $multi)
            ? $package = $this->_xml = $this->_xml->addChild('package')
            : $package = $this->_xml->addChild('package');

        // Append subfolder to the wpkg path
        $this->wpkg_path = $this->wpkg_path . DIRECTORY_SEPARATOR . 'packages';

        // Yep, reflector, because "get_class_vars" show all parameters (from parent also)
        $_ref = new \ReflectionClass('WPKG\Classes\Packages\Package');
        $_packages = new Package();
        $_props_default = [];
        // Variables by default
        foreach ($_ref->getProperties() as $property) {
            if ($property->class === 'WPKG\Classes\Packages\Package') {
                $property_name = $property->getName();
                ($property_name[0] != "_") ? $_props_default[$property_name] = $_packages->$property_name : null;
            }
        }

        // Now we need read current variables
        $_ref = new \ReflectionClass($this);
        $_props_current = [];
        // Current variables
        foreach ($_ref->getProperties() as $property) {
            // Check for class
            if ($property->class === 'WPKG\Classes\Packages\Package') {
                $property_name = $property->getName();
                // Store into array variables with underline as first symbol
                ($property_name[0] != "_") ? $_props_current[$property_name] = $this->$property_name : null;
            }
        }

        // If some default parameters is overwrite, then add into the
        foreach ($_props_default as $key => $value) {
            switch ($key) {
                case 'id':
                    // If id is set then name of file was changes
                    if (isset($this->id)) {
                        $this->_filename = $this->id . '.xml';
                        $package->addAttribute($key, $_props_current[$key]);
                    }
                    break;
                case 'reboot':
                    $package->addAttribute($key, $_props_current[$key] ? 'true' : 'false');
                    break;
                default:
                    $package->addAttribute($key, $_props_current[$key]);
                    break;
            }
        }

        //
        // Variables part
        //
        foreach ($this->getVariables() as $key => $value) {
            $xml_variable = $package->addChild('variable');
            $xml_variable->addAttribute('name', $key);
            $xml_variable->addAttribute('value', $value);
        }

        //
        // Check part
        //
        foreach ($this->getChecks() as $checks_key => $checks_value) {
            $xml_check = $package->addChild('check');
            foreach ($checks_value as $checks_value_item) {
                $xml_check->addAttribute('type', $checks_key);
                $xml_check->addAttribute('condition', $checks_value_item['condition']);
                $xml_check->addAttribute('path', $checks_value_item['path']);
            }
        }

        //
        // Commands stage
        //
        $xml_commands = $package->addChild('commands');
        foreach ($this->getCommands() as $command_key => $command_value) {
            $xml_command = $xml_commands->addChild('command');

            foreach ($command_value as $command_value_item) {
                $xml_command->addAttribute('type', $command_key);
                $xml_command->addAttribute('cmd', $command_value_item['cmd']);

                if (!empty($command_value_item['include']))
                    $xml_command->addAttribute('include', $command_value_item['include']);

                // Parse the exit keys
                foreach ($command_value_item['exit'] as $exit_key => $exit_value) {
                    $xml_command_exit = $xml_command->addChild('exit');
                    $xml_command_exit->addAttribute('code', $exit_key);

                    if (!empty($exit_value))
                        $xml_command_exit->addAttribute('reboot', $exit_value ? 'true' : 'false');

                }
            }
        }

        return $this;
    }

}
