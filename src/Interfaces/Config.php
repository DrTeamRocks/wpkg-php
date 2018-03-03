<?php namespace WPKG\Interfaces;

interface Config
{
    /**
     * List of keys available by default
     */
    const KEYS = [
        Config::WPKG_BASE,
        Config::FORCE,
        Config::FORCE_INSTALL,
        Config::QUIT_ON_ERROR,
        Config::DEBUG,
        Config::DRY_RUN,
        Config::QUIET,
        Config::NO_NOTIFY,
        Config::NOTIFICATION_DISPLAY_TIME,
        Config::EXEC_TIMEOUT,
        Config::NO_REBOOT,
        Config::NO_RUNNING_STATE,
        Config::CASE_SENSITIVITY,
        Config::APPLY_MULTIPLE,
        Config::NO_DOWNLOAD,
        Config::REBOOT_CMD,
        Config::SETTINGS_FILE_NAME,
        Config::SETTINGS_FILE_PATH,
        Config::NO_FORCE_REMOVE,
        Config::NO_REMOVE,
        Config::sendStatus,
        Config::NO_UPGRADE_BEFORE_REMOVE,
        Config::SETTINGS_HOST_INFO,
        Config::VOLATILE_RELEASE_MARKER,
        Config::QUERY_MODE,
        Config::LOG_APPEND,
        Config::LOG_LEVEL,
        Config::LOG_FILE_PATH,
        Config::LOG_FILE_PATTERN,
        Config::PACKAGES_FILE_NAME,
        Config::PROFILES_FILE_NAME,
        Config::HOSTS_FILE_NAME,
        Config::PACKAGES_PATH,
        Config::PROFILES_PATH,
        Config::HOSTS_PATH,
        Config::WEB_PACKAGES_FILE_NAME,
        Config::WEB_PROFILES_FILE_NAME,
        Config::WEB_HOSTS_FILE_NAME,
        Config::SREG_PATH,
        Config::SREG_WPKG_RUNNING
    ];

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
     * Default: null
     */
    const WPKG_BASE = 'wpkg_base';

    /**
     * True : Do not consider wpkg.xml but check existence of packages.
     * False: Do not force re-detection. Use wpkg.xml to detect current package
     *        status
     *
     * Default: false
     */
    const FORCE = 'force';

    /**
     * True : Force installation over existing packages.
     * False: Skip package installation if package is already installed.
     *
     * Default: false
     */
    const FORCE_INSTALL = 'forceInstall';

    /**
     * True : Force the script to immediately quit on error.
     * False: Errors are logged but WPKG continues processing.
     *
     * Default: false
     */
    const QUIT_ON_ERROR = 'quitonerror';

    /**
     * True : Enable debug mode. Prints lots of ugly debug messages to event log.
     * False: Disable debug logging to event log.
     *
     * NOTE: This flag is independent from the log level setting. So you can even
     *       enable debug logging to log files without setting this flag to true
     *       which prevents your event log to be flooded.
     *
     * Default: false
     */
    const DEBUG = 'debug';

    /**
     * True : Enable dryrun mode. Does not apply any changes to the system.
     *        Enables debug output and disables reboot.
     * False: Apply changes to the system.
     *
     * Default: false
     */
    const DRY_RUN = 'dryrun';

    /**
     * Should be set to true in case of unattended run (WPKG service).
     *
     * True : Disable all log messages printed to the console (cscript) or
     *        displayed as dialog boxes (wscript).
     * False: Alerts the user about ongoing activity using windows messaging.
     *
     * Default: false
     */
    const QUIET = 'quiet';

    /**
     * True : Disable user notification about WPKG actions using windows messaging.
     *        Should be set to true in case of unattended run (WPKG service)
     * False: Alerts the user about ongoing activity using windows messaging.
     *
     * Default: false
     */
    const NO_NOTIFY = 'nonotify';

    /**
     * Defines how long a user notification is displayed to the user. After
     * timeout has been reached the message will be closed. Specify 0 in order to
     * specify that messages are never closed automatically.
     * Note: This only works on Windows Vista or newer where msg.exe is
     * available.
     *
     * Default: 10
     */
    const NOTIFICATION_DISPLAY_TIME = 'notificationDisplayTime';

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
     * Default: 3600
     */
    const EXEC_TIMEOUT = 'execTimeout';

    /**
     * True : System does not reboot regardless of need.
     * False: Reboot the system as specified by packages.
     *
     * Default: false
     */
    const NO_REBOOT = 'noreboot';

    /**
     * True : Disable export of running state to Windows registry at
     *        HKCU\Software\WPKG\running
     * False: Export running state to Windows registry at HKCU\Software\WPKG\running
     *
     * Default: false
     */
    const NO_RUNNING_STATE = 'noRunningState';

    /**
     * True : Matching of package and profile IDs is case sensitive.
     * False: Disable case sensitivity for package and profile IDs.
     *        WPKG will consider the package ID "SomePackage" and "SoMePaCkAgE"
     *        the same.
     *
     * Default: true
     */
    const CASE_SENSITIVITY = 'caseSensitivity';

    /**
     * True : Match multiple host entries to a single host.
     * False: Only match one host entry to the executing host. If a matching host
     *        entry is found the algorithm stops looking for further matches.
     *        This way only one profile is assigned to a host.
     *
     * Default: false
     */
    const APPLY_MULTIPLE = 'applyMultiple';

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
     * Default: false
     */
    const NO_DOWNLOAD = 'noDownload';

    /**
     * Use the specified command for rebooting, either with full path or relative
     * to the location of wpkg.js.
     * Setting rebootCmd to "special" will use tools\psshutdown.exe from
     * from www.sysinternals.com - if it exists
     * Any other value will make WPKG to try executing the command specified as
     * <command> and then exit with code 3010.
     *
     * Default: "standard"
     */
    const REBOOT_CMD = 'rebootCmd';

    /**
     * Filename of the local package database (client-side) stored at
     * %SystemRoot%\system32 by default (see settings_file_path)
     *
     * Default: "wpkg.xml"
     */
    const SETTINGS_FILE_NAME = 'settings_file_name';

    /**
     * Path to the local package database (client-side). It is strongly suggested
     * to NOT set this parameter at all if not required.
     * Only change this parameter if you really know what you're doing.
     *
     * Default: "%SystemRoot%\\system32"
     */
    const SETTINGS_FILE_PATH = 'settings_file_path';

    /**
     * True : Disable forced removal of packages if they are removed from the
     *        profile AND the package database.
     *  NOTE: A client might continuously try to uninstall a package if an
     *        uninstall command fails.
     * False:
     *
     * Default: false
     */
    const NO_FORCE_REMOVE = 'noForcedRemove';

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
     * Default: false
     */
    const NO_REMOVE = 'noRemove';

    /**
     * Controls weather WPKG prints some information about its progress to
     * STDOUT. This output can be read by another program (GUI) to display some
     * progress bar or additional status information to the user.
     *
     * True : Enable status output on STDOUT.
     * False: Disable status output on STDOUT.
     *
     * Default: false
     */
    const sendStatus = false;

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
     * Default: false
     */
    const NO_UPGRADE_BEFORE_REMOVE = 'noUpgradeBeforeRemove';

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
     * Default: true
     */
    const SETTINGS_HOST_INFO = 'settingsHostInfo';

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
     * Default: null
     */
    const VOLATILE_RELEASE_MARKER = 'volatileReleaseMarker';

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
     * Default: "local"
     */
    const QUERY_MODE = 'queryMode';

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
     * Default: false
     */
    const LOG_APPEND = 'logAppend';

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
     * Default: "0xFF"
     */
    const LOG_LEVEL = 'logLevel';

    /**
     * Path where the logfiles are written to. This might be an UNC path on the
     * network as well as a local path. Environment variables are expanded.
     *
     * Examples:
     *     <param name='log_file_path' value='%TEMP%' />
     *     <param name='log_file_path' value='\\\\server\\share\\dir' />
     *
     * Default: "%TEMP%"
     */
    const LOG_FILE_PATH = 'log_file_path';

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
     * Default: "wpkg-[HOSTNAME].log"
     */
    const LOG_FILE_PATTERN = 'logfilePattern';

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
     * Default: "packages.xml", "profiles.xml", "hosts.xml"
     */
    const PACKAGES_FILE_NAME = 'packages_file_name';
    const PROFILES_FILE_NAME = 'profiles_file_name';
    const HOSTS_FILE_NAME = 'hosts_file_name';

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
     * Default: null, null, null
     */
    const PACKAGES_PATH = 'packages_path';
    const PROFILES_PATH = 'profiles_path';
    const HOSTS_PATH = 'hosts_path';

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
     * Default: "packages_xml_out.php", "profiles_xml_out.php", "hosts_xml_out.php"
     */
    const WEB_PACKAGES_FILE_NAME = 'web_packages_file_name';
    const WEB_PROFILES_FILE_NAME = 'web_profiles_file_name';
    const WEB_HOSTS_FILE_NAME = 'web_hosts_file_name';

    /**
     * Default: "SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Uninstall"
     */
    const SREG_PATH = 'sRegPath';

    /**
     * Default: "HKLM\\Software\\WPKG\\running"
     */
    const SREG_WPKG_RUNNING = 'sRegWPKG_Running';

    /**
     * Append any parameters into config
     *
     * @param   string $key
     * @param   mixed $value
     * @return  \WPKG\Interfaces\Config
     */
    public function with(string $key, $value): Config;

    /**
     * Append variable into array of config's variables
     *
     * @param   string $name - Name of variable
     * @param   string $value - Value
     * @param   null|string $os - Operation system name ['Windows xp','Windows 7'...]
     * @param   null|string $arch - Architecture of processor ['x86', 'x64'...]
     * @return  \WPKG\Interfaces\Config
     */
    public function withVariable(string $name, string $value, string $os = null, string $arch = null): Config;
}
