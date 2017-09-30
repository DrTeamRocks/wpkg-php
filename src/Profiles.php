<?php namespace WPKG;

/**
 * Class for work with Profiles.xml file or Profiles/ folder
 *
 * @link https://wpkg.org/Profiles.xml
 * @package DrTeam\WPKG
 */
class Profiles extends XML implements Interfaces\Profiles
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'profiles:profiles';

    /**
     * Name of file on filesystem
     * @var string
     */
    protected $_filename = 'profiles.xml';

    /**
     * Array of profiles
     * @var array
     */
    public $_profiles;

    /**
     * Hosts constructor.
     */
    public function __construct()
    {
        // List of attributes
        $this->_root_attributes = [
            'xmlns:profiles' => 'http://www.wpkg.org/profiles',
            'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.wpkg.org/profiles xsd/profiles.xsd'
        ];

        // Call the parent class now
        parent::__construct();
    }

    /**
     * Add new profile into the list
     *
     * @param string $profile
     * @param array|string|null $packages
     * @param array|string|null $depends
     * @return mixed
     */
    public function add(string $profile, $packages = null, $depends = null)
    {
        // Profile is array of values
        $this->_profiles[$profile] = [];

        // Append new profile into array
        if (!empty($depends))
            $this->_profiles[$profile]['depends'] = $depends;

        if (!empty($packages))
            $this->_profiles[$profile]['packages'] = $packages;

        return $this;
    }

    /**
     * Get array of hosts or single host
     *
     * @param string|null $profile
     * @return array|string
     */
    public function get(string $profile = null)
    {
        return !empty($profile) ? $this->_profiles[$profile] : $this->_profiles;
    }

    /**
     * Generate XML by data in memory
     *
     * @return object
     */
    public function build()
    {
        // Parse the hosts array
        foreach ($this->_profiles as $key => $value) {

            // Add the element into the XML
            $xml_profile = $this->_xml->addChild('profile');
            $xml_profile->addAttribute('id', $key);

            // If depends is set
            if (!empty($value['depends'])) {
                // Add dependencies
                if (is_array($value['depends'])) {
                    foreach ($value['depends'] as $depend) {
                        $xml_depends = $xml_profile->addChild('depends');
                        $xml_depends->addAttribute('profile-id', $depend);
                    }
                } else {
                    $xml_depends = $xml_profile->addChild('depends');
                    $xml_depends->addAttribute('profile-id', $value['depends']);
                }
            }

            // If packages is set
            if (!empty($value['packages'])) {
                // Add packages
                if (is_array($value['packages'])) {
                    foreach ($value['packages'] as $depend) {
                        $xml_packages = $xml_profile->addChild('packages');
                        $xml_packages->addAttribute('package-id', $depend);
                    }
                } else {
                    $xml_packages = $xml_profile->addChild('packages');
                    $xml_packages->addAttribute('package-id', $value['packages']);
                }
            }

        }
        return $this;
    }

}
