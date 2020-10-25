<?php
Class Departments{
    private $id;
    private $name;
    private $deleted;

    function getid(){
        return $this->id;
    }
    function setid($val){
        $this->id = $val;
    }
    function getname(){
        return $this->name;
    }
    function setname($val){
        $this->name = $val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($val){
        $this->deleted = $val;
    }

    function __construct(){

    }
    function savenew(){

    }

    function save(){

    }

    static public function addedit(){
        
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
