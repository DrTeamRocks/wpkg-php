<?php namespace WPKG;

/**
 * Class for work with Packages.xml file or Packages/ folder
 *
 * @link https://wpkg.org/Packages.xml
 * @package DrTeam\WPKGs
 */
class Packages extends XML implements Interfaces\Packages
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'packages:packages';

    /**
     * Short name of package
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
    public $revision = 0;

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
     * Set the command of package
     *
     * @param string|array $include
     * @param string $type
     * @param string $cmd
     * @param array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return object
     */
    public function setCommand($include, string $type, string $cmd, array $exit = [])
    {
        $this->_commands[$type]['include'] = $include;
        $this->_commands[$type]['cmd'] = $cmd;
        $this->_commands[$type]['exit'] = $exit;
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
        // Generate hash os parameters
        $name = md5($type . '+' . $condition . '+' . $path);

        // If check is not set, then add
        if (!isset($this->_check[$name])) {
            $this->_check[$name]['type'] = $type;
            $this->_check[$name]['condition'] = $condition;
            $this->_check[$name]['path'] = $path;
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
     * Packages constructor.
     */
    public function __construct()
    {
        // List of attributes
        $this->_root_attributes = [
            'xmlns:hosts' => 'http://www.wpkg.org/packages',
            'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.wpkg.org/packages xsd/packages.xsd'
        ];

        // Call the parent class now
        parent::__construct();

        // Append subfolder to the path
        $this->path .= '/Packages/';

        // If id is set then name of file was changes
        if (isset($this->id)) $this->_filename = $this->id . '.xml';
    }

    public function build()
    {
        $this->_xml = $this->_xml->addChild('package');

        // Yep, reflector, because "get_class_vars" show all parameters (from parent also)
        $_ref = new \ReflectionClass('WPKG\Packages');
        $_config = new Config();
        $_props_default = [];
        // Variables by default
        foreach ($_ref->getProperties() as $property) {
            if ($property->class === 'WPKG\Packages') {
                $property_name = $property->getName();
                ($property_name[0] != "_") ? $_props_default[$property_name] = $_config->$property_name : null;
            }
        }

        // Now we need read current variables
        $_ref = new \ReflectionClass($this);
        $_props_current = [];
        // Current variables
        foreach ($_ref->getProperties() as $property) {
            // Check for class
            if ($property->class === 'WPKG\Packages') {
                $property_name = $property->getName();
                // Store into array variables with underline as first symbol
                ($property_name[0] != "_") ? $_props_current[$property_name] = $this->$property_name : null;
            }
        }

        // If some default parameters is overwrite, then add into the
        foreach ($_props_default as $key => $value) {
            if ($key == 'reboot') {
                $this->_xml->addAttribute($key, $_props_current[$key] ? 'true' : 'false');
            } else {
                $this->_xml->addAttribute($key, $_props_current[$key]);
            }
        }

        //
        // Check part
        //
        foreach ($this->_check as $check) {
            $xml_check = $this->_xml->addChild('check');
            $xml_check->addAttribute('type', $check['type']);
            $xml_check->addAttribute('condition', $check['condition']);
            $xml_check->addAttribute('path', $check['path']);
        }

        //
        // Commands stage
        //
        $xml_commands = $this->_xml->addChild('commands');
        foreach ($this->_commands as $command_key => $command_value) {
            $xml_command = $xml_commands->addChild('command');
            $xml_command->addAttribute('include', $command_value['include']);
            $xml_command->addAttribute('condition', $command_value['condition']);
            $xml_command->addAttribute('path', $command_value['path']);

            // Parse the exit keys
            foreach ($command_value['exit'] as $exit_key => $exit_value) {
                $xml_command_exit = $xml_command->addChild('exit');
                $xml_command_exit->addAttribute('code', $exit_key);

                if (!empty($exit_value))
                    $xml_command_exit->addAttribute('reboot', $exit_value ? 'true' : 'false');

            }
        }
    }

}
