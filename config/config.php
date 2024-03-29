<?php

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
define("CSS",$ini["config"]["css"]["style"]);
define("FONT",$ini["config"]["css"]["font"]);

/**
* This file handles errors and sets the paths to different files and routes based on .ini files
* @author Alex Tuersley
*/
/**
 * This function handles exceptions, logging the detailed exception to a file and displaying a basic message to the user
 */
function exceptionHandler($e) {
	$msg = array("status" => "500", "message" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine());
	$usr_msg = array("status" => "500", "message" => "Internal Server Error");
	header("Access-Control-Allow-Origin: *"); 
	header("Content-Type: application/json; charset=UTF-8"); 
	header("Access-Control-Allow-Methods: GET, POST");
	echo json_encode($usr_msg);
	logError($msg);
  }
  
  /**
  * This function is an error handler that shwos the user a basic message and logs the detailed error to a file.
  */
  function errorHandler($errno, $errstr, $errfile, $errline) {
	if ($errno != 2 && $errno != 8) {
	  throw new Exception("Fatal Error Detected: [$errno] Internal Server Error", 1);
	  logError("Fatal Error Detected: [$errno] $errstr line: $errline");
	}
	else{
	  logError("Fatal Error Detected: [$errno] $errstr line: $errline");
	}
  }
  set_error_handler('errorHandler');
  set_exception_handler('exceptionHandler');
  
  /**
   * Loops through the classes folder and includes all php files in the page
   */
  function autoloadClasses($className) {
	 $filename = "classes\\" . strtolower($className) . ".class.php";
	 $filename = str_replace('\\', DIRECTORY_SEPARATOR, $filename);
	 if (is_readable($filename)) {
	   include_once $filename;
	 } else {
	  throw new exception("File not found: " . $className . " (" . $filename . ")");
	 }
  
  }
  
  
  
  /**
   * @param $Error - an error passed from one of the handlers with information on what error has been triggered
   * This function writes the error passed to it to an error log file which is stored on the server
   */
  function logError($Error){
	$fileHandle = fopen("error_log_file.log", "ab");
	$errorMsg = date('D M j G:i:s T Y');
	$errorMsg .= $Error;
	fwrite($fileHandle, "$errorMsg\r\n");
	fclose($fileHandle);
  }
  
  
  spl_autoload_register("autoloadClasses");
  
  ?>