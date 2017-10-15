<?php namespace WPKG\Importers;

use \WPKG\Classes\Hosts\XMLOptions;
use \WPKG\Classes\Hosts\Host as XML_Host;
use \WPKG\Classes\Hosts\Hosts as XML_Hosts;

class Hosts extends XML_Hosts
{
    /**
     * Include DOM errors
     */
    use Errors;

    /**
     * Load the document
     * @return Hosts
     */
    public function load()
    {
        $this->loadFile();
        $this->validate();
        $this->parse();

        return $this;
    }

    public function loadFile()
    {
        $this->_dom->load($this->wpkg_path . DIRECTORY_SEPARATOR . $this->_filename);
        return $this;
    }

    /**
     * Execute the validation step
     * @return $this
     */
    public function validate()
    {
        // Enable user error handling
        libxml_use_internal_errors(true);

        // Validate the schema by XSD
        if (!$this->_dom->schemaValidate($this->_xsd)) {
            echo "<b>DOMDocument::schemaValidate() Generated Errors!</b>\n";
            $this->libxml_display_errors();
            die();
        }
        return $this;
    }

    /**
     * Parse the single node or
     * @param   null $node
     * @return  array|Hosts
     */
    public function parse($node = null)
    {
        // Read the document
        $node = ($node == null) ? $node = $this->_dom->documentElement : $node;

        // Read the child elements
        $child = $node->childNodes;

        // Empty profiles array
        $profile = [];

        // Parse the items
        foreach ($child as $item) {
            // Get the node name
            switch ($item->nodeName) {
                case 'host':
                    // Get the attribute name
                    $name = $item->getAttribute('name');

                    // If name is not empty
                    if (!empty($name)) {
                        // Single host
                        $_host = new XML_Host();
                        $_host->wpkg_path = $this->wpkg_path;
                        $_host->name = $name;

                        // Check for child inside
                        $item->hasChildNodes()
                            ? $_host->profileId = array_merge([$item->getAttribute('profile-id')], $this->parse($item))
                            : $_host->profileId = $item->getAttribute('profile-id');

                        $this->set($_host);
                    }
                    break;
                case 'profile':
                    $profile[] = $item->getAttribute('id');
                    break;
            }
        }
        return !empty($profile) ? $profile : $this;
    }
}
