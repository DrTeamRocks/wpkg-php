<?php namespace WPKG\Interfaces;

interface Profiles
{
    /**
     * Add new profile into the list
     *
     * @param   \WPKG\Interfaces\Profile $profile
     * @return  \WPKG\Interfaces\Profiles
     */
    public function setProfile(Profile $profile): Profiles;

    /**
     * Get array of profiles or single profile
     *
     * @param   string|null $profile_id - Profile ID
     * @return  array|\WPKG\Interfaces\Profile - Return array of profiles or single profile
     */
    public function getProfile(string $profile_id = null);
}
