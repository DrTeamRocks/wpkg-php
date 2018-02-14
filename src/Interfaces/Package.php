<?php namespace WPKG\Interfaces;

interface Package
{
    /**
     * Set some variable
     *
     * @param   string $name
     * @param   string $value
     * @return  \WPKG\Interfaces\Package
     */
    public function setVariable(string $name, string $value): Package;

    /**
     * Get some variable or array of variables
     *
     * @param   string $name - Name of required variable
     * @return  array|string
     */
    public function getVariables(string $name = null);

    /**
     * Set the command of package
     *
     * @param   string $type
     * @param   string $cmd
     * @param   string|array|null $include
     * @param   array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return  \WPKG\Interfaces\Package
     */
    public function setCommand(string $type, string $cmd, $include = null, array $exit = []): Package;

    /**
     * Get all commands or single command for current package
     *
     * @param   string|null $type
     * @return  array
     */
    public function getCommands(string $type = null): array;

    /**
     * Setter of check value
     *
     * @param   string $type
     * @param   string $condition
     * @param   string $path
     * @return  \WPKG\Interfaces\Package
     */
    public function setCheck(string $type, string $condition, string $path): Package;

    /**
     * Getter of checks
     *
     * @param   string|null $type
     * @return  array
     */
    public function getChecks(string $type = null): array;

    /**
     * Generate XML tree by data in memory
     *
     * @param   bool $multi - Multiple files mode
     * @return  \WPKG\Interfaces\Package
     */
    public function build(bool $multi = false): Package;
}
