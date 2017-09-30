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
     * Name of file on filesystem
     * @var string
     */
    protected $_filename = 'packages.xml';

    /**
     * Short name of package
     * @var string
     */
    public $id;

    /**
     * Long name of package
     * @var string
     */
    public $name;

    /**
     * Numeric version of revision, need for upgrade event
     * @var int
     */
    public $revision;

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
    private $_check = [];

    /**
     * List of commands
     * @var array
     */
    private $_commands = [];

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
    }


}
