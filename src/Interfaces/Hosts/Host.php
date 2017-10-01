<?php namespace WPKG\Interfaces\Hosts;

interface Host
{
    /**
     * Generate XML by data in memory
     *
     * @return string
     */
    public function build();
}
