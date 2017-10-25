<?php namespace WPKG\Classes\Profiles;

use \WPKG\Interfaces\Profile as ProfileInterface;

/**
 * Class for work with Profiles.xml file or Profiles/ folder
 *
 * @link https://wpkg.org/Profiles.xml
 * @package WPKG\Classes\Profiles
 */
class Profile extends XMLOptions implements ProfileInterface
{
    /**
     * Name of profile
     * @var string
     */
    public $id;

    /**
     * Dependencies of current profile
     * @var array|string
     */
    public $depends;

    /**
     * Packages which should be installed
     * @var array|string
     */
    public $packages;

    /**
     * Generate XML by data in memory
     *
     * @param bool $multi - Multiple files mode
     * @return object
     */
    public function build(bool $multi = false)
    {
        // If multiple files mode enabled
        (true === $multi)
            ? $profile = $this->_xml = $this->_xml->addChild('profile')
            : $profile = $this->_xml->addChild('profile');

        // Current name as filename
        $this->_filename = $this->id . '.xml';

        // Append subfolder to the wpkg path
        $this->wpkg_path = $this->wpkg_path . DIRECTORY_SEPARATOR . 'profiles';

        $profile->addAttribute('id', $this->id);

        // If depends is set
        if (!empty($this->depends)) {
            // Add dependencies
            if (is_array($this->depends)) {
                foreach ($this->depends as $depend) {
                    $xml_depends = $profile->addChild('depends');
                    $xml_depends->addAttribute('profile-id', $depend);
                }
            } else {
                $xml_depends = $profile->addChild('depends');
                $xml_depends->addAttribute('profile-id', $this->depends);
            }
        }

        // If packages is set
        if (!empty($this->packages)) {
            // Add packages
            if (is_array($this->packages)) {
                foreach ($this->packages as $depend) {
                    $xml_packages = $profile->addChild('packages');
                    $xml_packages->addAttribute('package-id', $depend);
                }
            } else {
                $xml_packages = $profile->addChild('packages');
                $xml_packages->addAttribute('package-id', $this->packages);
            }
        }

        return $this;
    }

}
