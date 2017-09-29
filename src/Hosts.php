<?php namespace WPKG;

/**
 * Class for work with Hosts.xml file or Hosts/ folder
 *
 * @link https://wpkg.org/Hosts.xml
 * @package DrTeam\WPKG
 */
class Hosts extends XML implements Interfaces\Hosts
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'hosts:wpkg';

    /**
     * Name of file on filesystem
     * @var string
     */
    protected $_filename = 'hosts.xml';

    /**
     * Array of hosts
     * @var array
     */
    public $_hosts;

    /**
     * Hosts constructor.
     */
    public function __construct()
    {
        // List of attributes
        $this->_root_attributes = [
            'xmlns:hosts' => 'http://www.wpkg.org/hosts',
            'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.wpkg.org/hosts xsd/hosts.xsd'
        ];

        // Call the parent class now
        parent::__construct();
    }

    /**
     * Generate the XML
     *
     * @param string $hostname
     * @param array|string $profile
     * @return string
     */
    public function add(string $hostname, $profile)
    {
        // Append new host into array
        $this->_hosts[$hostname] = $profile;
        return $this;
    }

    /**
     * Get array of hosts or single host
     *
     * @param string|null $hostname
     * @return array|string
     */
    public function get(string $hostname = null)
    {
        return !empty($hostname) ? $this->_hosts[$hostname] : $this->_hosts;
    }

    /**
     * Generate XML by data in memory
     *
     * @return object
     */
    public function build()
    {
        // Parse the hosts array
        foreach ($this->_hosts as $key => $value) {

            // Add the element into the XML
            $xml_host = $this->_xml->addChild('host');
            $xml_host->addAttribute('name', $key);

            // Check for array of profiles
            if (is_array($value)) {
                // Small hack for main profile-id
                if (!empty($value[0])) {
                    $xml_host->addAttribute('profile-id', $value[0]);
                    unset($value[0]);
                }
                // Now we need parse another profiles
                foreach ($value as $profile) {
                    $xml_profile = $xml_host->addChild('profile');
                    $xml_profile->addAttribute('id', $profile);
                }
            } else {
                $xml_host->addAttribute('profile-id', $value);
            }
        }
        return $this;
    }

    /**
     * Show current view of XML file
     *
     * @return mixed
     */
    public function show()
    {
        // Generate the XML
        $this->build();

        //Format XML to save indented tree rather than one line
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->_xml->asXML());
        //Echo XML - remove this and following line if echo not desired
        return $dom->saveXML();
    }

    /**
     * Save the file on filesystem
     *
     * @return bool
     */
    public function save()
    {
        // Return bool answer about file saving operation
        return $this->_xml->asXML($this->path . DIRECTORY_SEPARATOR . $this->_filename);
    }

    /**
     * Show existed XML file on filesystem
     *
     * @return mixed
     */
    public function read()
    {
        return file_get_contents($this->path . DIRECTORY_SEPARATOR . $this->_filename);
    }
}