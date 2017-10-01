<?php namespace WPKG\Interfaces\Profiles;

interface Profile
{
    /**
     * Generate XML tree by data in memory
     *
     * @return mixed
     */
    public function build();
}
