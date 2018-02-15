<?php namespace WPKG\Importers;

class Hosts extends \WPKG\Classes\Hosts\Hosts
{
    /**
     * Include extensions of class
     */
    use Errors, Import;

    /**
     * Parse the single node or main
     *
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
                        $_host = new \WPKG\Classes\Hosts\Host();
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
