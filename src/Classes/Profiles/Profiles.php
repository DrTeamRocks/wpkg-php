<?php namespace WPKG\Classes\Profiles;

use \WPKG\Interfaces\Profile as ProfileInterface;
use \WPKG\Interfaces\Profiles as ProfilesInterface;

/**
 * Class for work with Profiles.xml file or Profiles/ folder
 *
 * @link https://wpkg.org/Profiles.xml
 * @package WPKG\Classes\Profiles
 */
class Profiles extends XMLOptions implements ProfilesInterface
{
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
     * Add new profile into the list
     *
     * @param ProfileInterface $profile
     * @return object
     */
    public function set(ProfileInterface $profile)
    {
        // Profile is array of values
        $this->_profiles[$profile->id] = $profile;
        return $this;
    }

    /**
     * Get array of profiles or single profile
     *
     * @param string|null $id - Profile ID
     * @return array|Profile - Return array of profiles or single profile
     */
    public function get(string $id = null)
    {
        return !empty($id) ? $this->_profiles[$id] : $this->_profiles;
    }

    /**
     * Generate XML by data in memory
     *
     * @return object
     */
    public function build()
    {
        // Read profiles array and build the XML tree
        foreach ($this->_profiles as $profile) {
            $this->append($this->_xml, $profile->build(true)->_xml);
        }
        return $this;
    }

}
