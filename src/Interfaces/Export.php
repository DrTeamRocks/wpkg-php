<?php namespace WPKG\Interfaces;

interface Export
{
    /**
     * Build configuration file from data in array
     *
     * @param   array $array - Incoming array for convert
     * @param   string $mode - Work mode, Hosts, Packages etc
     * @return  string
     */
    public function build(array $array, string $mode): string;

}
