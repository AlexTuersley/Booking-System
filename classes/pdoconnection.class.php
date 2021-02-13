<?php 

  class PDOConnection
  {
    //Variables to store global variables locally, set in the config.ini
    var $c_server = DBSERVER;
    var $c_username = DBUSER;
    var $c_password = DBPASS;
    var $c_dbname = DBNAME;
    var $c_connection;
    
    //Tries to connect to a MySQL server using the variables
    function PDOConnection()
    {      
      try{      
        $conn = new PDO("mysql:host=".$this->c_server.";dbname=".$this->c_dbname, $this->c_username,$this->c_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->c_connection = $conn;        
      }
      catch(PDOException $e){
        echo "PDO Error: " . $e->getMessage();
      }
            
    }
    
    /**
     * Using parameters passed through attempts too query the DB
     * @param $sql
     * @param array $params - an array of parameters to be used in the query
     * @param $debug - 
     */
    public function query($sql,$params){            
      $conn = $this->c_connection;
      $stmt = $conn->prepare($sql);
      
      if(!($params == null || sizeof($params) == 0)){
        foreach ($params as $value) {          
          $stmt->bindParam($value['Label'],$value['Value'],$value['Type']);          
        }
      }

      $stmt->execute();
      
      return $stmt;
      
    }
    
    //returns the ID of the last database query
    public function getLastInsertId(){
      return $this->c_connection->lastInsertId();
    }
    
    /**
     * creates an sqlarray from the variables entered
     * @param string $Label - used to identify the Value in the query
     * @param $Value - variable to be put into the Database
     * @param $Type - defines the Type of the Value e.g. string, int etc
     */
    static public function sqlarray($Label,$Value,$Type){
      $Arr = array("Label"=>$Label,"Value"=>$Value,"Type"=>$Type);
      return $Arr;
    }
    
  }

 ?>