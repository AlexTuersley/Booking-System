<?php
//define('CONFIGLOCATION', 'config/config.xml');
// turn on all possible errors
error_reporting(-1);
// display errors, should be value of 0, in a production system of course
ini_set("display_errors", 1);

/**
 * Looks in the config.ini file to get database information which will direct to
 * the server that is storing the booking system database
 */
$ini['config'] = parse_ini_file("config.ini",true);
define('DBSERVER', $ini['config']['database']['dbserver']);
define('DBNAME', $ini['config']['database']['dbname']);
define('DBUSER', $ini['config']['database']['dbuser']);
define('DBPASS', $ini['config']['database']['dbpass']);
define('SALT', $ini['config']['database']['salt']);

/**
* loops through all php files in class directory and include them 
*/
function autoloadClasses($className) {
	$filename = "classes/" . $className . ".php";
	if (is_readable($filename)) {
	     include $filename;
	}
}

spl_autoload_register("autoloadClasses");

?>