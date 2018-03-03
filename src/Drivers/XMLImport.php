<?php namespace WPKG\Drivers;

use WPKG\Drivers\XML\Errors;

class XMLImport
{
    use Errors;

    /**
     * @var
     */
    private $_xml;

    /**
     * Convert XML to array
     *
     * @param   string $xml - XML in plain text format
     * @return  mixed
     */
    public function convert(string $xml)
    {
        $this->_xml = simplexml_load_string($xml);
        $array = json_decode(json_encode((array)$this->_xml), true);

        return $this->unserialize($array);
    }

    public function unserialize(array $array)
    {
        $out = false;
        foreach ($array as $key => $value) {
            $prefix = '\\WPKG\\Drivers\\XML\\';
            $class = $prefix . ucfirst("${key}s");
            $class = new $class();
            $out = $class->import($value);
        }
        return $out;
    }
}