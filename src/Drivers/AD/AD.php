<?php namespace WPKG\Drivers\AD;

use \Adldap\Adldap;

trait AD
{
    /**
     * @var Adldap
     */
    private $_adldap;

    /**
     * Create AD object and call loading procedure
     *
     * @throws \Exception
     */
    private function connect()
    {
        try {
            // If connection is empty
            if (empty($this->_adldap)) {
                // Create adLDAP object by parameters from config
                $this->_adldap = new Adldap($this->getConfig());

                if (empty($this->_adldap)) {
                    throw new \Exception('Could not connect to Domain controller.');
                }
            }

        } catch (\Exception $e) {
            die("Error in " . $e->getFile() . " line " . $e->getLine() . ": " . $e->getMessage() . "\n");
        }

        return $this;
    }
}
