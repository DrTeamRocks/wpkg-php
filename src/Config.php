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
            Exceptions::arrayKeyAllowed($key, Config::KEYS);

            // Add value into the array
            $this->_config['param'][] = [
                'name' => $key,
                'value' => $value
            ];

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
     * @param   null|string $os - Operation system name ['Windows xp','Windows 7'...]
     * @param   null|string $arch - Architecture of processor ['x86', 'x64'...]
     * @return  \WPKG\Interfaces\Config
     */
    public function withVariable(string $name, string $value, string $os = null, string $arch = null): Interfaces\Config
    {
        $array = [
            'name' => $name,
            'value' => $value
        ];

        if (!empty($os)) $array['os'] = $os;
        if (!empty($arch)) $array['architecture'] = $arch;

        $this->_config['variables'][] = $array;

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
