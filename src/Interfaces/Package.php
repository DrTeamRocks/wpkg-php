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
        Package::EXECUTE,
        Package::INCLUDE
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
     */
    const EXECUTE = 'execute';

    /**
     * List of included packages
     */
    const INCLUDE = 'include';

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
     * @param   null|string $os - Operation system name ['Windows xp','Windows 7'...]
     * @param   null|string $arch - Architecture of processor ['x86', 'x64'...]
     * @return  \WPKG\Interfaces\Package
     */
    public function withVariable(string $name, string $value, string $os = null, string $arch = null): Package;

    /**
     * Get array of variables
     *
     * @return  array
     */
    public function getVariables(): array;

    /**
     * Set the command of package
     *
     * @param   string $type
     * @param   string|null $cmd
     * @param   mixed $include
     * @param   null|PackageCheckExits $exits - List of exit codes [0, 3010 => true, 'any', 2]
     * @return  \WPKG\Interfaces\Package
     */
    public function withCommand(string $type, string $cmd = null, $include = null, PackageCheckExits $exits = null): Package;

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
     * @param   string $value
     * @return  \WPKG\Interfaces\Package
     */
    public function withCheck(string $type, string $condition, string $path, string $value = null): Package;

    /**
     * Get all checks or checks by some specific type
     *
     * @param   string|null $type
     * @return  array
     */
    public function getCheck(string $type = null): array;

    /**
     * Add includes of current package
     *
     * @param   string $include
     * @return  \WPKG\Interfaces\Package
     */
    public function withInclude(string $include): Package;

    /**
     * Take a list of includes
     *
     * @return  array
     */
    public function getInclude(): array;

}
