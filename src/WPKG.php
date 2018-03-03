<?php namespace WPKG;

class WPKG
{
    private $_factory;

    public function build(array $array, string $type = 'xml', string $mode)
    {
        $type = strtoupper($type);
        $driver = "\\WPKG\\Drivers\\$type";
        $this->_factory = new $driver();

        // Convert all boolean variables to text
        array_walk_recursive($array, function(&$value) {
            if (is_bool($value)) {
                $value = $this->bool2text($value);
            }
        });

        return $this->_factory->build($array, $mode);
    }

    protected function bool2text(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}
