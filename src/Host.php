<?php namespace WPKG;

/**
 * Class for work with Hosts.xml file or Hosts/ folder
 *
 * @link https://wpkg.org/Hosts.xml
 * @package WPKG
 */
class Host extends Hosts implements Interfaces\Host
{
    /**
     * Get current object
     *
     * @return  array
     */
    public function getCurrent(): array
    {
        return $this->_hosts['host'][0];
    }

    /**
     * Get parameter by keyname or all if key is not set
     *
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
                Exceptions::arrayKeyAllowed($key, Host::KEYS);
                Exceptions::arrayKeyDefined($key, $this->_hosts['host'][0]);

                // Return value from array
                $result = $this->_hosts['host'][0][$key];
            } else {
                // Return all values from array
                $result = $this->_hosts['host'][0];
            }
        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $result;
    }

    /**
     * Add some parameter of host
     *
     * @param   string $key
     * @param   mixed $value
     * @return  \WPKG\Interfaces\Host
     */
    public function with(string $key, $value): Interfaces\Host
    {
        try {
            // Check parameters
            Exceptions::arrayKeyAllowed($key, Host::KEYS);

            // Add value into the array
            $this->_hosts['host'][0][$key] = $value;

        } catch (\Exception $e) {
            echo "Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n";
        }

        return $this;
    }
}
