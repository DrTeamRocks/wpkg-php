<?php namespace WPKG;

class WPKG
{
    private $_factory;

    public function build(array $array, string $type = 'xml', string $mode)
    {
        $type = strtoupper($type);
        $driver = "\\WPKG\\Drivers\\$type";
        $this->_factory = new $driver();
        return $this->_factory->build($array, $mode);
    }
}
