<?php namespace WPKG\Interfaces;

interface Import
{
    /**
     * Build WPKG object from data
     *
     * @param   $data - Incoming data for import
     * @return  mixed
     */
    public function import($data);

}
