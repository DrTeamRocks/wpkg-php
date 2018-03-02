<?php namespace WPKG;

/**
 * Class for work with Profiles.xml file or Profiles/ folder
 *
 * @link https://wpkg.org/Profiles.xml
 * @package WPKG
 */
class Profiles extends WPKG implements Interfaces\Profiles
{
    /**
     * Array of profiles
     * @var array
     */
    protected $_profiles;

    /**
     * Add new profile into the list
     *
     * @param   Interfaces\Profile $profile
     * @return  Interfaces\Profiles
     */
    public function setProfile(Interfaces\Profile $profile): Interfaces\Profiles
    {
        // Profile is array of values
        $this->_profiles[] = $profile->getCurrent();
        return $this;
    }

    /**
     * Get array of profiles or single profile
     *
     * @param   string|null $profile_id - Profile ID
     * @return  array|\WPKG\Interfaces\Profile - Return array of profiles or single profile
     */
    public function getProfile(string $profile_id = null)
    {
        return !empty($profile_id)
            ? array_search(['id' => $profile_id], $this->_profiles)
            : $this->_profiles;
    }

    /**
     * Show document in required format
     *
     * @param   string $mode
     * @return  bool|string
     */
    public function show(string $mode = 'xml')
    {
        return $this->build($this->_profiles, $mode, 'Profiles');
    }

}
