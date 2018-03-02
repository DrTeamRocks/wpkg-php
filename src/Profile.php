<?php namespace WPKG;

/**
 * Class for work with Profiles.xml file or Profiles/ folder
 *
 * @link https://wpkg.org/Profiles.xml
 * @package WPKG
 */
class Profile extends Profiles implements Interfaces\Profile
{
    private $_keys = [
        Profile::ID,
        Profile::DEPENDS,
        Profile::PACKAGES
    ];

    /**
     * Get current profile
     *
     * @return  array
     */
    public function getCurrent(): array
    {
        return $this->_profiles[0];
    }

    /**
     * Get value of some specific key or of all keys from current profile
     *
     * @param   string|null $key - Key name
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
                Exceptions::arrayKeyDefined($key, $this->_profiles[0]);

                // Return value from array
                $result = $this->_profiles[0][$key];
            } else {
                // Return all values from array
                $result = $this->_profiles[0];
            }
        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $result;
    }

    /**
     * Add (replace if exist) some parameter of current profile
     *
     * @param   string $key - Key name
     * @param   mixed $value - Any value it can be string, number or array
     * @return  \WPKG\Interfaces\Profile
     */
    public function with(string $key, $value): Interfaces\Profile
    {
        try {
            // Check parameters
            Exceptions::arrayKeyAllowed($key, $this->_keys);

            // Add value into the array
            $this->_profiles[0][$key] = $value;

        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $this;
    }
}
