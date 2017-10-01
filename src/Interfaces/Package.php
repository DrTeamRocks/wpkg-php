<?php namespace WPKG\Interfaces;

interface Package
{
    /**
     * Generate XML by data in memory
     *
     * @return object
     */
    public function build();
}
