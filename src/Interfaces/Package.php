<?php namespace WPKG\Interfaces;

interface Package
{
    /**
     * List of keys available by default
     */
    const KEYS = [
        Package::ID,
        Package::NAME,
        Package::REVISION,
        Package::REBOOT,
        Package::PRIORITY,
        Package::EXECUTE
    ];

    /**
     * Short name of package (used as filename, must be unique)
     */
    const ID = 'id';

    /**
     * Long name of package
     */
    const NAME = 'name';

    /**
     * Numeric version of revision, need for upgrade event
     */
    const REVISION = 'revision';

    /**
     * Reboot after install, upgrade or remove of package
     */
    const REBOOT = 'reboot';

    /**
     * Priority of package
     */
    const PRIORITY = 'priority';

    /**
     * Execution period (optional)
     * @var string
     */
    const EXECUTE = 'execute';

    /**
     * Get current object
     *
     * @return  array
     */
    public function getCurrent(): array;

    /**
     * Add some parameter of package
     *
     * @param   string $key
     * @param   mixed $value
     * @return  \WPKG\Interfaces\Package
     */
    public function with(string $key, $value): Package;

    /**
     * Get parameter by keyname or all if key is not set
     *
     * @param   string|null $key
     * @return  mixed
     */
    public function getParam(string $key = null);

    /**
     * Set some variable
     *
     * @param   string $name
     * @param   string $value
     * @return  \WPKG\Interfaces\Package
     */
    public function withVariable(string $name, string $value): Package;

    /**
     * Get some variable or array of variables
     *
     * @param   string $name - Name of required variable
     * @return  array|string
     */
    public function getVariable(string $name = null);

    /**
     * Set the command of package
     *
     * @param   string $type
     * @param   string|null $cmd
     * @param   mixed $include
     * @param   array $exit - List of exit codes [0, 3010 => true, 'any', 2]
     * @return  \WPKG\Interfaces\Package
     */
    public function withCommand(string $type, string $cmd = null, $include = null, array $exit = []): Package;

    /**
     * Get all commands or single command for current package
     *
     * @param   string|null $type
     * @return  array
     */
    public function getCommand(string $type = null): array;

    /**
     * Add some important check into array
     *
     * @param   string $type
     * @param   string $condition
     * @param   string $path
     * @return  \WPKG\Interfaces\Package
     */
    public function withCheck(string $type, string $condition, string $path): Package;

    /**
     * Get all checks or checks by some specific type
     *
     * @param   string|null $type
     * @return  array
     */
    public function getCheck(string $type = null): array;

}
