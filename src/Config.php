<?php namespace WPKG;

/**
 * Class for work with Config.xml file within the same directory as you place wpkg.js.
 *
 * @link https://wpkg.org/Config.xml
 * @package DrTeam\WPKG
 */
class Config extends XML
{
    /**
     * Current namespace
     * @var string
     */
    protected $_root = 'config';

    /**
     * Name of file on filesystem
     * @var string
     */
    protected $_filename = 'config.xml';

    /**
     * If you use wpkg_web, you can set wpkg_base to the base URL of your
     * WPKG_Web installation. NO TRAILING SLASH (/). This will allow WPKG to
     * use the web generated XML file and not require further XML Exports to the
     * file system.
     *
     * Examples:
     *     <param name='wpkg_base' value='http://wpkg.mydomain.com' />
     *     <param name='wpkg_base' value='http://www.mydomain.com/wpkg_web' />
     *     <param name='wpkg_base' value='http://USER:PASS@wpkg.mydomain.com' />
     *
     * NOTE: Replace USER and PASS with the required credentials to access your
     *       installation. Configure this user in config.php for WPKG_Web
     *       version 1.1.0 and greater.
     *
     * NOTE: If you would like to use the flat XML file instead of the web based
     *       method, leave the variable declaration as followed:
     *       <param name='wpkg_base' value='' />
     *
     * NOTE: It is deprecated now to use HTTP URL values in wpkg_base. Instead you
     *       might have a look at the [packages|hosts|profiles]_paths parameters.
     *       There you can specify even mixed paths using HTTP and file/directory
     *       references. If a valid path is specified in wpkg_base then relative
     *       paths in [packages|hosts|profiles]_paths are relative to wpkg_base.
     *       If wpkg_base refers to an HTTP URL it is ignored when
     *       [packages|hosts|profiles]_paths is used and wpkg_base defaults to the
     *       location of wpkg.js.
     *
     * @var string
     */
    public $wpkg_base = '';

    /**
     * True : Do not consider wpkg.xml but check existence of packages.
     * False: Do not force re-detection. Use wpkg.xml to detect current package
     *        status
     *
     * @var bool
     */
    public $force = false;

    /**
     * True : Force installation over existing packages.
     * False: Skip package installation if package is already installed.
     *
     * @var bool
     */
    public $forceInstall = false;

    /**
     * True : Force the script to immediately quit on error.
     * False: Errors are logged but WPKG continues processing.
     *
     * @var bool
     */
    public $quitonerror = false;

    /**
     * True : Enable debug mode. Prints lots of ugly debug messages to event log.
     * False: Disable debug logging to event log.
     *
     * NOTE: This flag is independent from the log level setting. So you can even
     *       enable debug logging to log files without setting this flag to true
     *       which prevents your event log to be flooded.
     *
     * @var bool
     */
    public $debug = false;

    /**
     * True : Enable dryrun mode. Does not apply any changes to the system.
     *        Enables debug output and disables reboot.
     * False: Apply changes to the system.
     *
     * @var bool
     */
    public $dryrun = false;

    /**
     * Should be set to true in case of unattended run (WPKG service).
     *
     * True : Disable all log messages printed to the console (cscript) or
     *        displayed as dialog boxes (wscript).
     * False: Alerts the user about ongoing activity using windows messaging.
     *
     * @var bool
     */
    public $quiet = false;

    /**
     * True : Disable user notification about WPKG actions using windows messaging.
     *        Should be set to true in case of unattended run (WPKG service)
     * False: Alerts the user about ongoing activity using windows messaging.
     *
     * @var bool
     */
    public $nonotify = false;

    /**
     * Defines how long a user notification is displayed to the user. After
     * timeout has been reached the message will be closed. Specify 0 in order to
     * specify that messages are never closed automatically.
     * Note: This only works on Windows Vista or newer where msg.exe is
     * available.
     *
     * @var int
     */
    public $notificationDisplayTime = 10;

    /**
     * Default command execution timeout. This is the default timeout used when
     * executing external commands. Each command which runs for longer than the
     * defined amount of seconds will be be regarded as failed and WPKG will
     * continue execution.
     * NOTE: You can override the default timeout using the timeout=xxx attribute
     * on command definition. It is strongly recommended to keep the default as-is
     * and just define custom timeouts on commands which are known to finish within
     * a shorter timeframe or of course if commands are known to run longer than
     * the default timeout.
     *
     * @var int
     */
    public $execTimeout = 3600;

    /**
     * True : System does not reboot regardless of need.
     * False: Reboot the system as specified by packages.
     *
     * @var bool
     */
    public $noreboot = false;

    /**
     * True : Disable export of running state to Windows registry at
     *        HKCU\Software\WPKG\running
     * False: Export running state to Windows registry at HKCU\Software\WPKG\running
     *
     * @var bool
     */
    public $noRunningState = false;

    /**
     * True : Matching of package and profile IDs is case sensitive.
     * False: Disable case sensitivity for package and profile IDs.
     *        WPKG will consider the package ID "SomePackage" and "SoMePaCkAgE"
     *        the same.
     *
     * @var bool
     */
    public $caseSensitivity = true;

    /**
     * True : Match multiple host entries to a single host.
     * False: Only match one host entry to the executing host. If a matching host
     *        entry is found the algorithm stops looking for further matches.
     *        This way only one profile is assigned to a host.
     *
     * @var bool
     */
    public $applyMultiple = false;

    /**
     * True : Disable all downloads. In this mode all download instructions
     *        will be simply ignored. Exactly the same way as if they were not
     *        specified in the XML at all. Use this option with caution as your
     *        install commands might require the files downloaded in download
     *        specifications.
     *        This switch/setting might be used on hosts which get the packages
     *        synchronized to the download target so the download files already
     *        exist before WPKG execution.
     * False: Default behavior. All downloads are executed as specified within
     *        the XML files.
     *
     * @var bool
     */
    public $noDownload = false;

    /**
     * Use the specified command for rebooting, either with full path or relative
     * to the location of wpkg.js.
     * Setting rebootCmd to "special" will use tools\psshutdown.exe from
     * from www.sysinternals.com - if it exists
     * Any other value will make WPKG to try executing the command specified as
     * <command> and then exit with code 3010.
     *
     * @var string
     */
    public $rebootCmd = 'standard';

    /**
     * Filename of the local package database (client-side) stored at
     * %SystemRoot%\system32 by default (see settings_file_path)
     *
     * @var string
     */
    public $settings_file_name = 'wpkg.xml';

    /**
     * Path to the local package database (client-side). It is strongly suggested
     * to NOT set this parameter at all if not required.
     * Only change this parameter if you really know what you're doing.
     *
     * @var string
     */
    public $settings_file_path = '%SystemRoot%\\system32';

    /**
     * True : Disable forced removal of packages if they are removed from the
     *        profile AND the package database.
     *  NOTE: A client might continuously try to uninstall a package if an
     *        uninstall command fails.
     * False:
     *
     * @var bool
     */
    public $noForcedRemove = false;

    /**
     * True : Allows to disable removing of packages. If used in conjunction with
     *        the /synchronize parameter it will just add packages but never remove
     *        them. Instead of removing a list of packages which would have been
     *        removed during that session is printed on exit. Packages are not
     *        removed from the local settings database (wpkg.xml). Therefore it
     *        will contain a list of all packages ever installed.
     *  NOTE: Each package which is requested to be removed (manually or by
     *        a synchronization request) will be checked for its state by executing
     *        its included package checks. If the package has been removed manually
     *        it will also be removed from the settings database. Due to the fact
     *        that packages without checks always return 'false' for during the
     *        install-status check these packages will disappear from the local
     *        wpkg.xml.
     * False: Remove packages from the system if they are not listed within the
     *        profile any more.
     *
     * @var bool
     */
    public $noRemove = false;

    /**
     * Controls weather WPKG prints some information about its progress to
     * STDOUT. This output can be read by another program (GUI) to display some
     * progress bar or additional status information to the user.
     *
     * True : Enable status output on STDOUT.
     * False: Disable status output on STDOUT.
     *
     * @var bool
     */
    public $sendStatus = false;

    /**
     * Usually WPKG upgrades a package to the latest available version before it
     * removes the package. This allows administrators to fix bugs in the package
     * and assure proper removal.
     * However this feature can lead to (sometimes unexpected) re-execution of
     * packages. For example if execution=always is used the package will run
     * once again before it is finally removed.
     * It's advised to leave this option on default unless you really know what
     * you're doing.
     *
     * True : Disables the upgrade-before-remove feature
     * False: Leave the upgrade-before-remove feature enabled
     *
     * @var bool
     */
    public $noUpgradeBeforeRemove = false;

    /**
     * Allows to disable insert of host attributes to local settings DB. This is
     * handy for testing as the current test-suite compares the local wpkg.xml
     * database and the file will look different on all test machines if these
     * attribute are present. This setting might be removed if all test-cases
     * are adapted.
     *
     * True : Includes host information in local wpkg.xml attributes
     * False: Does not include any host information in local wpkg.xml
     *
     * @var bool
     */
    public $settingsHostInfo = true;

    /**
     * Marks volatile releases and "inverts" the algorithm that a longer
     * version number is newer. For example 1.0RC2 would be newer than 1.0 because
     * it appends characters to the version. Using "rc" as a volatile release
     * marker the algorithm ignores the appendix and assumes that the string which
     * omits the marker is newer.
     * Resulting in 1.0 to be treated as newer than 1.0RC2.
     * Caution: Be careful defining volatile release markers because it could have
     * undesired effects. For example specifying "b" would also make 1.0b5 appear
     * to be older than 1.0 (where "b" is usually a build number appended to the
     * version).
     * So please change this parameter only if you really know what you're doing.
     *
     * Currently the built-in list contains the following appendices:
     * "rc", "i", "m", "alpha", "beta", "pre", "prerelease"
     *
     * The parameter might be defined as many times as you like. Each entry will
     * add another entry to the list of volatile version markers.
     *
     * @var string
     */
    public $volatileReleaseMarker = '';

    /**
     * Allows to switch to remote mode where package verification is skipped.
     * remote: Disable package checks and assume that packages in settings
     *         database are still correctly installed. In remote mode also the
     *         host information is read from the local settings database.
     * local:  Default setting. Query verifies package status using all checks.
     * Note: Query mode can only be used with the query switch. It is ignored
     * if no /query: command line parameter is used.
     *
     * Details: If you intend to copy the local wpkg.xml file to a remote system
     * and execute WPKG queries based on this settings database (wpkg.xml) then
     * WPKG might print some packages as "required for installation" since the
     * package checks fail on the remote host as the package might not be
     * installed on the remote host. If remote mode is enabled, then WPKG assumes
     * that the packages are properly installed on the executing host without
     * actually verifying it.
     * Of course it might happen in this case that a package query on the remote
     * system says that a package does not need any change but on the real system
     * the user might have removed the software meanwhile which will trigger an
     * installation if WPKG is run on the client.
     *
     * Also note that in remote query mode WPKG will read all host attributes
     * from the settings file (wpkg.xml) if these attributes are available. This
     * includes hostname, architecture, OS, IP addresses, domainname, groups,
     * LCID of the executing user and LCID of the operating system.
     * This is required in order to allow evaluation of all conditional
     * attributes in exactly the same way as it will evaluate on the client.
     *
     * @var string
     */
    public $queryMode = 'local';

    /**
     * Specifies if the log file should be appended or overwritten.
     *
     * True : Log files are appended instead of overwritten. Please note that
     *        log files could grow quite large if debug level logging is enabled.
     *        Depending on the pattern (date and time used) a new log file might
     *        be written on each run.
     * False: Log files are overwritten on each run. This is the default setting
     *        and it is aimed for the target to keep only the log of the most
     *        recent WPKG run.
     *
     * @var bool
     */
    public $logAppend = false;

    /**
     * Log level is defined as a bitmask. Just sum up the values of each log
     * severity you would like to include within the log file and add this value
     * to your config.xml or specify it at /logLevel:<num>.
     * Specify 0 to disable logging.
     *  1: log errors only
     *  2: log warnings
     *  4: log information
     *  8: log audit success
     * 16: log audit failure
     *
     * Examples:
     *     31 log everything (1+2+4+8+16=31)
     *     13 log errors, information and audit success (1+4+8=13)
     *      3 log errors and warnings only (1+2=3)
     *
     * @var string
     */
    public $logLevel = '0xFF';

    /**
     * Path where the logfiles are written to. This might be an UNC path on the
     * network as well as a local path. Environment variables are expanded.
     *
     * Examples:
     *     <param name='log_file_path' value='%TEMP%' />
     *     <param name='log_file_path' value='\\\\server\\share\\dir' />
     *
     * @var string
     */
    public $log_file_path = '%TEMP%';

    /**
     * Pattern to generate the log file name.
     * Recognized patterns:
     * [HOSTNAME] replaced by the executing hostname
     * [PROFILE]  replaced by the applying profile name
     * [YYYY]     replaced by year (4 digits)
     * [MM]       replaced by month number (2 digits)
     * [DD]       replaced by the day of the month (2 digits)
     * [hh]       replaced by hour of the day (24h format, 2 digits)
     * [mm]       replaced by minutes (2 digits)
     * [ss]       replaced by seconds (2 digits)
     *
     * Examples:
     *     "wpkg-[YYYY]-[MM]-[DD]-[HOSTNAME].log" results in a name like
     *         "wpkg-2007-11-04-myhost.log"
     *
     * NOTE: Using [PROFILE] causes all log messages from before reading
     *       profiles.xml to be temporarily written to the local %TEMP% folder.
     *       So they might appear on the final log file with some delay.
     *
     * NOTE: The default pattern allows tracing of last execution without polluting
     *       the log directory. Subsequent executions will overwrite the same log
     *       file.
     *
     * @var string
     */
    public $logfilePattern = 'wpkg-[HOSTNAME].log';

    /**
     *  Names of the the XML input files.  Not used if base begins with "http".
     *  If packages_path, profiles_path and/or hosts_path is used then the
     *  *_file_name files are ignored.
     *
     * NOTE: These parameters are deprecated in favor of the more flexible
     *       [packages|hosts|profiles]_paths parameters which allow to specify
     *       multiple XML files and/or directories.
     *       If [packages|hosts|profiles]_paths is used WPKG will ignore the
     *       files specified in [package|profiles|hosts]_file_name parameters
     *       entirely.
     *
     * @var string
     */
    public $packages_file_name = 'packages.xml';
    public $profiles_file_name = 'profiles.xml';
    public $hosts_file_name = 'hosts.xml';

    /**
     *  Define paths where WPKG looks for XML files. Multiple paths can be
     *  specified using the pipe symbol (|) as paths-separrator.
     *  If any of the paths are specified WPKG will ignore the built-in defaults.
     *  For example if you specify packages_path WPKG will neither automatically
     *  open packags.xml nor look for XML files in the packages/ sub-folder.
     *  If a path points to a directory WPKG will look for *.xml files within the
     *  directory and parse them.
     *  Paths should be specified relative to the base path (see wpkg_base
     *  property). Absolute paths might work too but beware of authentication
     *  issues if you refer to a different host than the one WPKG is read from.
     *  Note: Do not forget to encode backslashes correctly using double-backslash.
     *        Alternatively you might use unix-like forward slashes.
     *
     * Examples:
     *     <param name='packages_path' value='packages.xml|packages' />
     *     <param name='packages_path' value='packages|custom-packages' />
     *     <param name='packages_path' value='packages|path\\directory' />
     *     <param name='packages_path' value='http://USER:PASS@wpkg.mydomain.com/packages.php' />
     *
     * @var string
     */
    public $packages_path = '';
    public $profiles_path = '';
    public $hosts_path = '';

    /**
     *  Names of the PHP scripts which output the XML files.  Only used if
     *  base begins with "http"
     *
     * NOTE: These parameters are deprecated in favor of the more flexible
     *       [packages|hosts|profiles]_paths parameters which allow to specify
     *       multiple XML files and/or directories as well as HTTP URLs.
     *       If [packages|hosts|profiles]_paths is used WPKG will ignore the
     *       HTTP URL specified in wpkg_base and therefore also the files
     *       specified in web_[packages|profiles|hosts]_file_name. So just insert
     *       complete URLs into [packages|hosts|profiles]_paths.
     *
     * @var string
     */
    public $web_packages_file_name = 'packages_xml_out.php';
    public $web_profiles_file_name = 'profiles_xml_out.php';
    public $web_hosts_file_name = 'hosts_xml_out.php';

    /**
     * @var string
     */
    public $sRegPath = 'SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Uninstall';

    /**
     * @var string
     */
    public $sRegWPKG_Running = 'HKLM\\Software\\WPKG\\running';

    /**
     * Variable definitions
     *
     * Use this section to define global variables which can be used during WPKG
     * runtime. Variables defined here are defined before WPKG execution starts.
     * Hots, Porfiles and Packages might overwrite these variables but the
     * initial value will be set as defined here.
     *
     * You can use WPKG conditional logic in order to define specific values for
     * individual system environemnts like architecture or operating system.
     *
     * Some examples are provided below.
     *
     * <variables>
     *     <variable name="PROG_FILES32" value="%PROGRAMFILES%\SomeSoftware" architecture="x86" />
     *     <variable name="PROG_FILES32" value="%PROGRAMFILES(x86)%\SomeSoftware" architecture="x64" />
     *     <variable name="DESKTOP" value="%ALLUSERSPROFILE%\Desktop" os="windows xp" />
     *     <variable name="DESKTOP" value="%PUBLIC%\Desktop" os="windows 7" />
     * </variables>
     *
     * @var array
     */
    private $_variables = [];

    /**
     * Append variables into array
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setVariable(string $name, string $value)
    {
        $this->_variables[$name] = $value;
        return $this;
    }

    /**
     * Unset some variable from array of variables
     *
     * @param string $name
     * @return $this
     */
    public function unsetVariable(string $name)
    {
        unset($this->_variables[$name]);
        return $this;
    }

    /**
     * Show single variable by name of all variables
     *
     * @param string|null $name
     * @return array|mixed
     */
    public function getVariable(string $name = null)
    {
        return !empty($name) ? $this->_variables[$name] : $this->_variables;
    }

    /**
     * Language definitions
     *
     * Defines language specific strings. Insert languages as you wish. Multiple
     * LCID codes might be handled by one language definition. Just separate them
     * by comma. A full list of LCIDs might be found at:
     * http://www.microsoft.com/globaldev/reference/lcid-all.mspx
     *
     * This is entirely optional. If a message is not defined here the script
     * will just print a built-in English message.
     *
     * Please note that the message has a maximum of 256 characters on Windows
     * Vista and newer operating systems due to limitation of the messaging
     * system. Longer messages will result in no message being displayed at all.
     *
     * @var array
     */
    private $_languages = ['english', 'french', 'german', 'italian', 'russian', 'spanish'];

    /**
     * Append new language
     *
     * @param string $name
     * @return $this
     */
    public function setLanguage(string $name)
    {
        // Need to find the value into array
        $key = array_search($name, $this->_languages);
        // If not found then append
        if (empty($key)) $this->_languages[] = $name;
        return $this;
    }

    /**
     * Unset language from list
     *
     * @param string $name
     * @return $this
     */
    public function unsetLanguage(string $name)
    {
        // Need to find the value into array
        $key = array_search($name, $this->_languages);
        // If found then unset
        if (!empty($key)) unset($this->_languages[$name]);
        return $this;
    }

    /**
     * Show all available languages
     *
     * @return array
     */
    public function getLanguages()
    {
        return $this->_languages;
    }

    /**
     * Hosts constructor.
     */
    public function __construct()
    {
        // List of attributes
        $this->_root_attributes = [
            'xmlns:profiles' => 'http://www.wpkg.org/config',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.wpkg.org/config xsd/config.xsd'
        ];

        // Call the parent class now
        parent::__construct();
    }

    /**
     * Generate XML
     *
     * @return object
     */
    public function build()
    {
        // Yep, reflector, because "get_class_vars" show all parameters (from parent also)
        $_ref = new \ReflectionClass('WPKG\Config');
        $_config = new Config();
        $_props_default = [];
        // Variables by default
        foreach ($_ref->getProperties() as $property) {
            if ($property->class === 'WPKG\Config') {
                $property_name = $property->getName();
                ($property_name[0] != "_") ? $_props_default[$property_name] = $_config->$property_name : null;
            }
        }

        // Now we need read current variables
        $_ref = new \ReflectionClass($this);
        $_props_current = [];
        // Current variables
        foreach ($_ref->getProperties() as $property) {
            // Check for class
            if ($property->class === 'WPKG\Config') {
                $property_name = $property->getName();
                // Store into array variables with underline as first symbol
                ($property_name[0] != "_") ? $_props_current[$property_name] = $this->$property_name : null;
            }
        }

        // If some default parameters is overwrite, then add into the
        foreach ($_props_default as $key => $value) {
            // If default value was changed
            if ($_props_current[$key] != $value) {
                // Append new param element
                $param = $this->_xml->addChild('param');
                $param->addAttribute('name', $key);

                // If value is boolean
                if (is_bool($_props_current[$key])) $_props_current[$key] = $_props_current[$key] ? 'true' : 'false';
                $param->addAttribute('value', $_props_current[$key]);
            }
        }

        //
        // Variables part
        //
        $xml_variables = $this->_xml->addChild('variables');
        foreach ($this->_variables as $variable) {
            $xml_language = $xml_variables->addChild('variable');
            $xml_language->addAttribute('name', $variable['name']);
            $xml_language->addAttribute('value', $variable['value']);
        }

        //
        // Languages part
        //
        $xml_languages = $this->_xml->addChild('languages');
        $_languages = new Languages();
        foreach ($this->_languages as $language) {
            // For first we need a language element
            $_language = $_languages->load($language);
            $xml_language = $xml_languages->addChild('language');
            $xml_language->addAttribute('lcid', $_language['lcid']);

            // Now need to add the translation strings
            foreach ($_language['strings'] as $string) {
                $xml_string = $xml_language->addChild('string', $string['text']);
                $xml_string->addAttribute('id', $string['id']);
            }
        }

        return $this;
    }

}
