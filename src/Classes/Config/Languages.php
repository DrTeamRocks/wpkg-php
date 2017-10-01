<?php namespace WPKG\Classes\Config;

/**
 * Class Language for loading languages
 * @package WPKG
 */
class Languages
{
    /**
     * Folder where localization files stored
     * @var string
     */
    public $path = __DIR__ . '/../../Languages';

    /**
     * Language constructor.
     * @param string|null $path
     */
    public function __construct(string $path = null)
    {
        // Overwrite path if set
        if ($path != null) $this->path = $path;
        return $this;
    }

    /**
     * Load language file by name
     *
     * @param string $name
     * @return array
     */
    public function load(string $name)
    {
        return include $this->path . '/' . $name . '.php';
    }
}