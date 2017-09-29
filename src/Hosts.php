<?php namespace DrTeam\WPKG;

/**
 * Class for work with Hosts.xml file or Hosts/ folder
 *
 * @link https://wpkg.org/Hosts.xml
 * @package DrTeam\WPKG
 */
class Hosts extends Root implements Interfaces\Worker
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'hosts:wpkg';

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
     * @param array $hosts List of hosts
     * @return string
     */
    public function create(array $hosts)
    {
        //$this->_xml->addChild('ws:make', null, 'ws');

        // Parse the hosts array
        foreach ($hosts as $host) {
            // Add the element into the XML
            $xml_host = $this->_xml->addChild('host');

            // Parse the host parameters
            foreach ($host as $key => $value) {
                switch ($key) {
                    // Hostname
                    case 'name':
                        $xml_host->addAttribute('name', $value);
                        break;

                    // Single profile or list of host's profiles
                    case 'profile':
                    case 'profiles':
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


                        break;
                }
            }
        }

        // Return XML text
        return $this->_xml->asXML();
    }
}