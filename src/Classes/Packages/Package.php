<?php namespace WPKG\Classes\Packages;

/**
 * Class for work with Packages/ folder
 *
 * @link https://wpkg.org/Packages.xml
 * @package WPKG\Classes\Packages
 */
class Package extends XMLOptions implements \WPKG\Interfaces\Packages\Package
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
     * Parameters for check
     * @var array
     */
    protected $_check = [];

    /**
     * List of commands
     * @var array
     */
    protected $_commands = [];

    /**
     * For packages shoul be multifile mode
     * @var bool
     */
    protected $_singleFile = false;

    /**
     * Set the command of package
     *
     * @param string $type
     * @param string $cmd
     * @param string|array|null $include
     * @param array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return object
     */
    public function setCommand(string $type, string $cmd, $include = null, array $exit = [])
    {
        // Generate hash of command
        $hash = md5($type . '+' . $cmd . '+');

        // If check is not set, then add
        if (!isset($this->_commands[$hash])) {
            $this->_commands[$hash]['type'] = $type;
            $this->_commands[$hash]['cmd'] = $cmd;
            $this->_commands[$hash]['include'] = $include;
            $this->_commands[$hash]['exit'] = $exit;
        }

        return $this;
    }

    /**
     * Get all commands or single command for current package
     *
     * @param string|null $type
     * @return array
     */
    public function getCommand(string $type = null)
    {
        return (empty($type)) ? $this->_commands : $this->_commands[$type];
    }

    /**
     * Setter of check value
     *
     * @param string $type
     * @param string $condition
     * @param string $path
     * @return $this
     */
    public function setCheck(string $type, string $condition, string $path)
    {
        // Generate hash of check
        $hash = md5($type . '+' . $condition . '+' . $path);

        // If check is not set, then add
        if (!isset($this->_check[$hash])) {
            $this->_check[$hash]['type'] = $type;
            $this->_check[$hash]['condition'] = $condition;
            $this->_check[$hash]['path'] = $path;
        }

        return $this;
    }

    /**
     * Getter of checks
     *
     * @return array
     */
    public function getChecks()
    {
        return $this->_check;
    }

    /**
     * Generate XML tree by data in memory
     *
     * @param bool $multi - Multiple files mode
     * @return mixed
     */
    public function build(bool $multi = false)
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
                    if (isset($this->id)) $this->_filename = $this->id . '.xml';
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
        // Check part
        //
        foreach ($this->_check as $check) {
            $xml_check = $package->addChild('check');
            $xml_check->addAttribute('type', $check['type']);
            $xml_check->addAttribute('condition', $check['condition']);
            $xml_check->addAttribute('path', $check['path']);
        }

        //
        // Commands stage
        //
        $xml_commands = $package->addChild('commands');
        foreach ($this->_commands as $command_key => $command_value) {
            $xml_command = $xml_commands->addChild('command');
            $xml_command->addAttribute('type', $command_value['type']);
            $xml_command->addAttribute('cmd', $command_value['cmd']);

            if (!empty($command_value['include']))
                $xml_command->addAttribute('include', $command_value['include']);

            // Parse the exit keys
            foreach ($command_value['exit'] as $exit_key => $exit_value) {
                $xml_command_exit = $xml_command->addChild('exit');
                $xml_command_exit->addAttribute('code', $exit_key);

                if (!empty($exit_value))
                    $xml_command_exit->addAttribute('reboot', $exit_value ? 'true' : 'false');

            }
        }

        return $this;
    }

}
