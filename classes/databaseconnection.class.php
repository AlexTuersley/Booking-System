<?php
/**
 * Create a database connection
 *
 * This uses the singleton pattern to return a database connection. 
 */
/*
class pdoDB {
  private static $dbConnection = null;
 
  private function __construct() {
  }
  private function __clone() {
  }
 
  /**
   * Return DB connection or create initial connection, if connection fails echo the error
   * 
   * @return object (PDO)
   */
  /*
  public static function getConnection() {
    $dbname = ApplicationRegistry::getDBName();
    if ( !self::$dbConnection ) {
        try {          
            echo"pass"; 
            self::$dbConnection = new PDO($dbname);
            self::$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);          
        }
        catch( PDOException $e ) {
            echo $e->getMessage();
         }
    }
    return self::$dbConnection;
  }
}*/
class PDOConnection
  {
    //Connection variables, DB variables are set in the config
    private $server = DBSERVER;
    private $username = DBUSER;
    private $password = DBPASS;
    private $dbname = DBNAME;
    private $connection;
    
    /**
    * creates a new sql connection stored in the $connection variable using a PDO and the stored variables to connect
    */
    function PDOConnection()
    {      
      try{      
        $conn = new PDO("mysql:host=".$this->server.";dbname=".$this->dbname, $this->username,$this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->connection = $conn;        
      }
      catch(PDOException $e){
        echo "PDO Error: " . $e->getMessage();
      }
            
    }
}
?>