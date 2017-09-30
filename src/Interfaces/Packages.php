<?php namespace WPKG\Interfaces;

interface Packages
{
    /**
     * Generate XML by data in memory
     *
     * @return string
     */
    public function build();
}
