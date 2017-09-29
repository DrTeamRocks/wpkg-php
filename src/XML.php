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
     * Workmode option, single file or multiple files
     * @var bool
     */
    public $singleFile = true;

    /**
     * Path with files on filesystem
     * @var string
     */
    public $path;

    /**
     * Root constructor.
     */
    public function __construct()
    {
        // Build new xml
        $this->_xml = new \SimpleXMLElement("<$this->_root/>", LIBXML_NOERROR);

        // Add attributes into the root
        foreach ($this->_root_attributes as $key => $value) {
            // >> ignore << - is important
            // Idk why but sxml lib cut the first element of namespace
            $this->_xml->addAttribute("ignore:$key", $value);
        }
    }
}
