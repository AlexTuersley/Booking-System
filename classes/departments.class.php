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
            $this->name = $row["departmentname"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
    }
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO departments(departmentname,deleted)VALUES(:departmenrtname,0)",array(
                                PDOConnection::sqlarray(":departmentname",PDO::PARAM_STR)
                            ));
    }

    function save(){
        $WQ = new WriteQuery("UPDATE departments SET departmentname = :departmentname WHERE id = :id",array(
                PDOConnection::sqlarray(":departmentname",PDO::PARAM_STR),
                PDOConnection::sqlarray(":id",PDO::PARAM_INT)
    ));
    }

    static public function addedit($DID){
        $name = $_GET["name"];
        if($DID > 0){
            $Department = new Departments($DID);
            $Department->setname($name);
            $Department->save();    
        }
        else{
            $Department = new Departments();
            $Department->setname($name);
            $Department->setdeleted(0);
            $Department->savenew();
        }
    }
    static public function listdepartments(){
        if(User::GetUserLevel() >= 1){
            $RQ = new ReadQuery("SELECT id FROM departments WHERE deleted = 0", null);
            print("<p class='lead'>The list below shows all departments</p><p>Click on a department to see the staff inside and select a staff member for bookings</p>");
            $Col1 = array("Department","department",1);
            $Col2 = array("Staff","staff",1);
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Department = new Departments($row["id"]);
                $Row1 = array($Department->getname());
                $Row2 = array(Departments::getuserdepartments($row["id"]));
            }
            $Cols = array($Col1,$Col2);
            $Rows = array($Row1,$Row2);
            Tables::generatedropdowntable("departmentstafftable",$Cols,$Rows);
        }
        else{
            print("<p class='lead'>You do not have permission to view this page. Redirecting to home</p>");
        }
    }
    static public function listdepartmentsadmin(){
        if(User::GetUserLevel() >= 3){
            $RQ = new ReadQuery("SELECT id FROM departments WHERE deleted = 0", null);
            print("<p class='lead'>The list below shows all departments</p><p>Click on the pencil to edit and the bin to delete departments</p>");
            $Col1 = array("Department","department",1);
            $Col2 = array("","operations",2);
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Department = new Departments($row["id"]);
                $Row1 = array($Department->getname());
                $Row2 = array(Departments::getuserdepartments($row["id"]));
            }
            $Cols = array($Col1,$Col2);
            $Rows = array($Row1,$Row2);
            Tables::generatedynamictable("admindepartmenttable",$Cols,$Rows);
        }
        else{
            print("<p class='lead'>You do not have permission to view this page. Redirecting to home</p>");
        }
    }
    static public function getdepartmentsarray(){
        if(User::GetUserLevel() >= 2){
            $RQ = new ReadQuery("SELECT id, name FROM departments WHERE deleted = 0", null);

            $ReturnArray = array();
            $Counter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $ReturnArray[$Counter] = array($row[0],$row[1]);
                $Counter ++;
            }

            return $ReturnArray;
        }

     
    }
    static public function editdepartmentform($Name, $DID){

    }

}

?>
