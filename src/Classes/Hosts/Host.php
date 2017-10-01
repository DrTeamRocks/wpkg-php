<?php namespace WPKG\Classes\Hosts;

/**
 * Class for work with Hosts.xml file or Hosts/ folder
 *
 * @link https://wpkg.org/Hosts.xml
 * @package WPKG\Classes\Hosts
 */
class Host extends XMLOptions implements \WPKG\Interfaces\Hosts\Host
{
    /**
     * Default hostname if not set
     * @var string
     */
    public $name = 'example';

    /**
     * Store the single profile of host or multiple profiles
     * @var string|array
     */
    public $profileId;

    /**
     * Generate XML tree by data in memory
     *
     * @param bool $multi
     * @return $this
     */
    public function build(bool $multi = false)
    {
        // If multiple files mode enabled
        (true === $multi)
            ? $host = $this->_xml = $this->_xml->addChild('host')
            : $host = $this->_xml->addChild('host');

        // Append subfolder to the wpkg path
        $this->wpkg_path = $this->wpkg_path . DIRECTORY_SEPARATOR . 'hosts';

        // Current name as filename
        $this->_filename = $this->name . '.xml';

        // Add the element into the XML
        $host->addAttribute('name', $this->name);

        // Check for array of profiles
        if (is_array($this->profileId)) {
            // Small hack for main profile-id
            if (!empty($this->profileId[0])) {
                $host->addAttribute('profile-id', $this->profileId[0]);
                unset($this->profileId[0]);
            }
            // Now we need parse another profiles
            foreach ($this->profileId as $profile) {
                $xml_profile = $host->addChild('profile');
                $xml_profile->addAttribute('id', $profile);
            }
        } else {
            // If profile it's just a name, then we just need to add the attribute
            $host->addAttribute('profile-id', $this->profileId);
        }

        return $this;
    }

}
