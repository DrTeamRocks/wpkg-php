<?php namespace WPKG\Classes;

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
     * Path to the XSD file
     * @var string
     */
    protected $_xsd;

    /**
     * Object of XML class
     * @var \SimpleXMLElement
     */
    protected $_xml;

    /**
     * Object of DOM class
     * @var \DOMDocument
     */
    protected $_dom;

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
        // Build new Dom object
        $this->_dom = new \DOMDocument("1.0", "UTF-8");

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
     * Merge two XML trees
     *
     * @param $parent
     * @param $child
     */
    protected function append(&$parent, &$child)
    {
        // Create new DOMElements from the two SimpleXMLElements
        $dom1 = dom_import_simplexml($parent);
        $dom2 = dom_import_simplexml($child);
        // Import the  into the  document
        $dom2 = $dom1->ownerDocument->importNode($dom2, TRUE);
        // Append the  to
        $dom1->appendChild($dom2);
    }

    /**
     * Make XML more readable
     *
     * @return \DOMDocument
     */
    private function prettify()
    {
        $dom = $this->_dom;
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
        // Return bool answer about file saving operation
        return $this->prettify()->save($this->wpkg_path . DIRECTORY_SEPARATOR . $this->_filename);
    }

    /**
     * Show existed XML file on filesystem
     *
     * @return mixed
     */
    public function read()
    {
        return file_get_contents($this->wpkg_path . DIRECTORY_SEPARATOR . $this->_filename);
    }
}
