<?php namespace WPKG;

abstract class XML
{
    /**
     * Root namespace
     * @var string
     */
    protected $_root;

    /**
     * Attributes of root namespace
     * @var array
     */
    protected $_root_attributes;

    /**
     * Object of XML class
     * @var \SimpleXMLElement
     */
    protected $_xml;

    /**
     * Name of XML file
     * @var string
     */
    protected $_filename;

    /**
     * Path with WPKG configuration files on the filesystem
     * @var string
     */
    public $wpkg_path;

    /**
     * Root constructor.
     */
    public function __construct()
    {
        // Build new xml
        $this->_xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><$this->_root/>", LIBXML_NOERROR);

        // Add attributes into the root
        foreach ($this->_root_attributes as $key => $value) {
            // >> ignore << - is important
            // Idk why but sxml lib cut the first element of namespace
            $this->_xml->addAttribute("ignore:$key", $value);
        }
    }

    /**
     * Make XML more readable
     *
     * @return \DOMDocument
     */
    private function prettify() {
        // Yeah, I know it's a crap, but only DOMDocument can make XML more pretty
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->_xml->asXML());
        return $dom;
    }

    /**
     * Show current view of XML file
     *
     * @return mixed
     */
    public function show()
    {
        return $this->prettify()->saveXML();
    }

    /**
     * Save the file on filesystem
     *
     * @return bool
     */
    public function save()
    {
        echo $this->path . DIRECTORY_SEPARATOR . $this->_filename."\n";
        // Return bool answer about file saving operation
        return $this->prettify()->save($this->path . DIRECTORY_SEPARATOR . $this->_filename);
    }

    /**
     * Show existed XML file on filesystem
     *
     * @return mixed
     */
    public function read()
    {
        return file_get_contents($this->path . DIRECTORY_SEPARATOR . $this->_filename);
    }
}
