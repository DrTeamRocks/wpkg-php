<?php namespace WPKG\Interfaces;

interface Host
{
    /**
     * Generate XML tree by data in memory
     *
     * @param bool $multi - Multiple files mode
     * @return mixed
     */
    public function build(bool $multi = false);
}
