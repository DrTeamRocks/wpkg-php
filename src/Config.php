<?php namespace WPKG;

/**
 * Class for work with Config.xml file within the same directory as you place wpkg.js.
 *
 * @link https://wpkg.org/Config.xml
 * @package WPKG
 */
class Config extends WPKG implements Interfaces\Config
{
    /**
     * List of keys available by default
     * @var array
     */
    private $_keys = [
        Config::WPKG_BASE,
        Config::FORCE,
        Config::FORCE_INSTALL,
        Config::QUIT_ON_ERROR,
        Config::DEBUG,
        Config::DRY_RUN,
        Config::QUIET,
        Config::NO_NOTIFY,
        Config::NOTIFICATION_DISPLAY_TIME,
        Config::EXEC_TIMEOUT,
        Config::NO_REBOOT,
        Config::NO_RUNNING_STATE,
        Config::CASE_SENSITIVITY,
        Config::APPLY_MULTIPLE,
        Config::NO_DOWNLOAD,
        Config::REBOOT_CMD,
        Config::SETTINGS_FILE_NAME,
        Config::SETTINGS_FILE_PATH,
        Config::NO_FORCE_REMOVE,
        Config::NO_REMOVE,
        Config::sendStatus,
        Config::NO_UPGRADE_BEFORE_REMOVE,
        Config::SETTINGS_HOST_INFO,
        Config::VOLATILE_RELEASE_MARKER,
        Config::QUERY_MODE,
        Config::LOG_APPEND,
        Config::LOG_LEVEL,
        Config::LOG_FILE_PATH,
        Config::LOG_FILE_PATTERN,
        Config::PACKAGES_FILE_NAME,
        Config::PROFILES_FILE_NAME,
        Config::HOSTS_FILE_NAME,
        Config::PACKAGES_PATH,
        Config::PROFILES_PATH,
        Config::HOSTS_PATH,
        Config::WEB_PACKAGES_FILE_NAME,
        Config::WEB_PROFILES_FILE_NAME,
        Config::WEB_HOSTS_FILE_NAME,
        Config::SREG_PATH,
        Config::SREG_WPKG_RUNNING
    ];

    /**
     * @var array
     */
    private $_config = [];

    /**
     * @var Languages
     */
    private $_languages;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->_languages = new Languages();
        $this->_config['languages'] = $this->_languages->load();
    }

    /**
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
                Exceptions::arrayKeyDefined($key, $this->_config);

                // Return value from array
                $result = $this->_config[$key];
            } else {
                // Return all values from array
                $result = $this->_config;
            }
        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $result;
    }

    /**
     * Append any parameters into config
     *
     * @param   string $key
     * @param   mixed $value
     * @return  \WPKG\Interfaces\Config
     */
    public function with(string $key, $value): Interfaces\Config
    {

        try {
            // Check parameters
            Exceptions::arrayKeyAllowed($key, $this->_keys);

            // Add value into the array
            $this->_config[$key] = $value;

        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $this;
    }

    /**
     * Append variable into array of config's variables
     *
     * @param   string $name - Name of variable
     * @param   string $value - Value
     * @param   array $options - Extra options
     * @return  \WPKG\Interfaces\Config
     */
    public function withVariable(string $name, string $value, array $options = []): Interfaces\Config
    {
        $this->_config['variables'][] = [
            'name' => $name,
            'value' => $value,
            'options' => $options
        ];

        return $this;
    }

    /**
     * Show single variable by name of all variables
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->_config['variables'];
    }

    /**
     * Show document in required format
     *
     * @param   string $mode
     * @return  bool|string
     */
    public function show(string $mode = 'xml')
    {
        return $this->build($this->_config, $mode, 'Config');
    }

}
