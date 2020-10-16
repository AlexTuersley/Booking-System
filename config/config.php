<?php
//define('CONFIGLOCATION', 'config/config.xml');
// turn on all possible errors
error_reporting(-1);
// display errors, should be value of 0, in a production system of course
ini_set("display_errors", 1);

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