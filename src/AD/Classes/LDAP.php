<?php namespace WPKG\AD\Classes;

use WPKG\Host;

trait LDAP
{
    /**
     * A list of computers
     * @var array
     */
    private $_adldap_computers;

    /**
     * Parse groups and return the array of profile names
     * @param string|array $groups
     * @return array
     */
    private function extractGroups($groups)
    {
        $output = [];
        if (is_array($groups)) {
            foreach ($groups as $group) {
                $groupName = explode(',', $group)[0];
                $output[] = mb_substr($groupName, 3);
            }
        } else {
            $groupName = explode(',', $groups)[0];
            $output[] = mb_substr($groupName, 3);
        }
        return $output;
    }

    /**
     * Import computers from Active Directory
     */
    private function loadComputers()
    {
        // Get computers from LDAP
        $this->_adldap_computers = @$this->_adldap->computer()->all();
        // Set computer to list
        foreach ($this->_adldap_computers as $computer) {
            $groups = !empty($computer['memberof'])
                ? $this->extractGroups($computer['memberof'])
                : null;

            // Let's create new host object
            $host = new Host();
            $host->name = $computer['cn'];
            $host->profileId = $groups;

            // Add host to list
            $this->set($host);
        }
        return $this;
    }
}
