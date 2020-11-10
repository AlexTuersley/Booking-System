<?php 

  class PDOConnection
  {
    
    var $c_server = DBSERVER;
    var $c_username = DBUSER;
    var $c_password = DBPASS;
    var $c_dbname = DBNAME;
    var $c_connection;
    
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
    
    public function query($sql,$params,$debug){            
      if($debug){
        echo($sql . "<br />");
        echo"Params: ";
        echo$params;
        print_r($params);
        echo("<br />" . sizeof($params));
        echo("<br />");
      }
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
    
    public function getLastInsertId(){
      return $this->c_connection->lastInsertId();
    }
    
    static public function sqlarray($Label,$Value,$Type){
      $Arr = array("Label"=>$Label,"Value"=>$Value,"Type"=>$Type);
      return $Arr;
    }
    
  }

 ?>