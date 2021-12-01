<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


defined('NO_DATA')        OR define('NO_DATA', 0); // no errors
defined('SUCCESS')          OR define('SUCCESS', 1); // generic error
defined('INACTIVE_ACCOUNT')         OR define('INACTIVE_ACCOUNT', 2); // configuration error
defined('EMAIL_EXIST')   OR define('EMAIL_EXIST', 4); // file not found
defined('FAILURE')  OR define('FAILURE', 5); // unknown class



define('CURRENCY', '$');

define("TBL_PREFIX", "tbl_");
define("TBL_CATEGORIES", TBL_PREFIX . "categories");
define("TBL_SUBCATEGORIES", TBL_PREFIX . "subcategories");
define("TBL_PRODUCTS", TBL_PREFIX . "products");
define("TBL_CITY", TBL_PREFIX . 'city');
define("TBL_STATE", TBL_PREFIX . 'state');
define("TBL_COUNTRY", TBL_PREFIX . 'country');
define("TBL_USERS", TBL_PREFIX . 'users');
define("TBL_DEVICE_TOKENS", TBL_PREFIX . 'device_token');
define("TBL_OWNERS", TBL_PREFIX . 'owner');
define("TBL_RESTAURANTS", TBL_PREFIX . 'restaurants');
define("TBL_ADDRESS", TBL_PREFIX . 'user_addresses');
define("TBL_ORDERS", TBL_PREFIX . 'orders');
define("TBL_ORDERDETAIL", TBL_PREFIX . 'order_details');
define("TBL_NOTIFICATIONS", TBL_PREFIX . 'notification');    
define("TBL_TRANSACTION", TBL_PREFIX . 'transaction');
define("TBL_SETTINGS", TBL_PREFIX . 'settings');
define("TBL_EARNINGS", TBL_PREFIX . 'earnings');
define("TBL_ORDER_DRIVERS", TBL_PREFIX . 'driver_orders');
define("TBL_DRIVER_REVIEW", TBL_PREFIX . 'drivers_review');
define("TBL_RESTAURANT_REVIEW", TBL_PREFIX . 'restaurants_review');
define("TBL_COUPONS", TBL_PREFIX . 'coupons');
define("TBL_CONTACT_US", TBL_PREFIX . 'contact_us');
define("TBL_PAGES", TBL_PREFIX . 'pages');
define("TBL_DELIVERY_CHARGES", TBL_PREFIX . 'delivery_charges');
define("tbl_drivers_company", TBL_PREFIX . 'drivers_company');
define("tbl_restaurants", TBL_PREFIX . 'restaurants');