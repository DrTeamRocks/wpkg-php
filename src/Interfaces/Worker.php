<?php namespace DrTeam\WPKG\Interfaces;

interface Worker
{
    /**
     * Generate the XML from array
     *
     * @param array $array
     * @return string
     */
    public function create(array $array);
    /**
     * Generate the array from XML
     *
     * @param string $xml
     * @return array
     */
    //public function read(string $xml);

    /**
     * Save the file on filesystem
     *
     * @param string $xml
     * @param string $path
     * @return bool
     */
    //public function save(string $xml, string $path);

    /**
     * Remove file by path
     *
     * @param string $path
     * @return bool
     */
    //public function delete(string $path);
}
