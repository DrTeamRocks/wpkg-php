<?php namespace WPKG;

/**
 * Class Language for loading languages
 * @package WPKG
 */
class Languages
{
    /**
     * Default path with languages
     * @var string
     */
    private $_path = __DIR__ . '/Languages';

    /**
     * Language definitions
     * @var array
     */
    private $_languages = ['english', 'french', 'german', 'italian', 'russian', 'spanish'];

    /**
     * Language constructor.
     * @param string|null $path
     */
    public function __construct(string $path = null)
    {
        // Overwrite path if set
        if ($path != null) $this->setPath($path);
        return $this;
    }

    /**
     * @param string $languages_path
     * @return $this
     */
    public function setPath(string $languages_path)
    {
        $this->_path = $languages_path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->_path;
    }

    /**
     * Show all available languages or only selected
     *
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->_languages;
    }

    /**
     * Load language file by name or all available languages
     *
     * @param string|null $name - Name of language
     * @return array
     */
    public function load(string $name = null)
    {
        $out = [];
        if (empty($name)) {
            foreach ($this->getLanguages() as $language) {
                $out[] = include $this->getPath() . DIRECTORY_SEPARATOR . $language . '.php';
            }
        } else {
            $out = include $this->getPath() . DIRECTORY_SEPARATOR . $name . '.php';
        }
        return $out;
    }

}
