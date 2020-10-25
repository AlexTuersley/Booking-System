<?php
Class Departments{

    //Class Variables
    private $id;
    private $name;
    private $deleted;

    //getter and setter functions
    function getid(){
        return $this->id;
    }
    function setid($Val){
        $this->id = $Val;
    }
    function getname(){
        return $this->name;
    }
    function setname($Val){
        $this->name = $Val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($Val){
        $this->deleted = $Val;
    }

    function __construct(){
        if($ID > 0){

            $RQ = new ReadQuery("SELECT * FROM departments WHERE id = :departmentid", array(
                PDOConnection::sqlarray(":departmentid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->name = $row["name"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
    }
    function savenew(){

    }

    function save(){

    }

    static public function addedit($DID){
        
    }
    static public function listdepartmentsadmin(){
        if(User::GetUserLevel() >= 3){
            $RQ = new ReadQuery("SELECT id FROM departments WHERE deleted = 0", null);
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){

            }
        }
    }
    static public function getdepartmentsarray(){
        if(User::GetUserLevel() >= 2){
            $RQ = new ReadQuery("SELECT id, name FROM departments WHERE deleted = 0", null);

            $ReturnArray = array();
            $Counter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $ReturnArray[$Counter] = array($row[0],$row[1] . " " . $row[2]);
                $Counter ++;
            }

            return $ReturnArray;
        }

     
    }
    static public function editdepartmentform($Name, $DID){

    }

}

?>
