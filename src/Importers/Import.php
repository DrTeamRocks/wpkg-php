<?php namespace WPKG\Importers;

trait Import
{
    /**
     * Load the document
     * @return $this
     */
    public function load()
    {
        $this->loadFile();
        $this->validate();
        $this->parse();

        return $this;
    }

    /**
     * Load file from filesystem
     * @return $this
     */
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
}