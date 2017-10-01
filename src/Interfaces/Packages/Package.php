<?php namespace WPKG\Interfaces\Packages;

interface Package
{
    /**
     * Set the command of package
     *
     * @param string $type
     * @param string $cmd
     * @param string|array|null $include
     * @param array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return object
     */
    public function setCommand(string $type, string $cmd, $include = null, array $exit = []);

    /**
     * Get all commands or single command for current package
     *
     * @param string|null $type
     * @return array
     */
    public function getCommand(string $type = null);

    /**
     * Setter of check value
     *
     * @param string $type
     * @param string $condition
     * @param string $path
     * @return $this
     */
    public function setCheck(string $type, string $condition, string $path);

    /**
     * Getter of checks
     *
     * @return array
     */
    public function getChecks();

    /**
     * Generate XML tree by data in memory
     *
     * @param bool $multi - Multiple files mode
     * @return mixed
     */
    public function build(bool $multi = false);
}
