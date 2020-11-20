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

    function __construct($ID = 0){
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
        $WQ = new WriteQuery("INSERT INTO departments(departmentname,deleted)VALUES(:departmentname,0)",array(
                                PDOConnection::sqlarray(":departmentname",$this->getname(),PDO::PARAM_STR)
                            ));
    }

    function save(){
        $WQ = new WriteQuery("UPDATE departments SET departmentname = :departmentname WHERE id = :id",array(
                PDOConnection::sqlarray(":departmentname",$this->getname(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":id",$this->getid(),PDO::PARAM_INT)
    ));
    }
    static public function delete($DID){
        $RQ = new ReadQuery("SELECT * FROM userinformation WHERE department = :department",array(
            PDOConnection::sqlarray(":department",$DID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getnumberofresults() > 0){
            return false;
        }
        else{
            $WQ = new WriteQuery("UPDATE departments SET deleted = 1 WHERE id =: id",array(
                PDOConnection::sqlarray(":id",$DID,PDO::PARAM_INT)
            ));
        }
        return true;

    }
    static public function addedit($DID){
        $name = htmlspecialchars(filter_var($_POST["departmentname"], FILTER_SANITIZE_STRING));
        $Submit = $_POST["submit"];
        $DepartmentError = array("Please enter a Department Name","departmenterror");
        if($Submit){
            if($name != ""){    
                if($DID > 0){
                    $Department = new Departments($DID);
                    $Department->setname($name);
                    $Department->save();    
                }
                else{
                    $Department = new Departments();
                    $Department->setname($name);
                    $Department->savenew();
                }
            }
            else{
                $Errors = array($DepartmentError);
                Forms::generateerrors("Please correct the following errors before continuing.",$Errors);
            }
        }
        if($DID > 0){
            $Department = new Departments($DID);
            Departments::departmentform($DID, $Department->getname());
        }
        else{
            Departments::departmentform($DID,$name);
        }
     
    }
    static public function listdepartments(){
        if($_SESSION["userlevel"] >= 1){
            $RQ = new ReadQuery("SELECT id FROM departments WHERE deleted = 0", null);
            print("<p class='Welcome'>The list below shows all departments</p><p class='welcome'>Click on a department to see the staff inside and select a staff member for bookings</p>");
            $Col1 = array("Department","department",1);
            $Col2 = array("","functions",2);
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Department = new Departments($row["id"]);
                $Row1 = array($Department->getname());
                $Row2 = array(Departments::getuserdepartments($row["id"]));
            }
            $Cols = array($Col1,$Col2);
            $Rows = array($Row1,$Row2);
            Display::generatedropdowndisplay("departmentstafftable",$Cols,$Rows);
        }
        else{
            print("<p class='welcome'>You do not have permission to view this page. Redirecting to home</p>");
        }
    }
    static public function listdepartmentsadmin(){
           if($_SESSION["userlevel"] >= 3){
            $RQ = new ReadQuery("SELECT * FROM departments WHERE deleted = 0", null);
            print("<p class='welcome'>The list below shows all departments</p>");
            Forms::generateaddbutton("Add Department","department.php?edit=-1","plus","primary","","","Click this button to add new Departments");
            $Col1 = array("Department","department",1);
            $Col2 = array("","functions",2);
            $Rows = array();
            $RowCounter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Row1 = array($row["departmentname"]);
                $Row2 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit ".$row["department"]."'></i></a>","button");
                $Row3 = array("<a alt='Delete ".$row["departmentname"]."' onclick='deletedepartmentdialog('" . $row["departmentname"] . "','" . $row["id"] . "');'><i class='fas fa-trash-alt' title='Delete ".$row["departmentname"]."'></i></a>","button");
                $Rows[$RowCounter] = array($Row1,$Row2,$Row3);
                $RowCounter++;
            }
            $Cols = array($Col1,$Col2);

            Display::generatetabledisplay("admindepartmenttable",$Cols,$Rows);
        }
        else{
            print("<p class='welcome'>You do not have permission to view this page. Redirecting to home</p>");
        }
    }
    static public function getdepartmentsarray(){
       
            $RQ = new ReadQuery("SELECT id, departmentname FROM departments WHERE deleted = 0", null);

            $ReturnArray = array();
            $ReturnArray[0] = array(0,"No Department");
            $Counter = 1;

            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $ReturnArray[$Counter] = array($row[0],$row[1]);
                $Counter ++;
            }

            return $ReturnArray;     
    }
    static public function departmentform($DID,$name){
        Forms::generateaddbutton("Departments","department.php","arrow-left","secondary");
        $NameField = array("Name: ","Text","departmentname",30,$name,"Enter the name of the Department","","","","Name of the Department e.g. Business");
        if($DID > 0){
            $Button = "Edit Department";
        }
        else{
            $Button = "Add Department";
        }
        $Fields = array($NameField);
        Forms::generateform("departmentform","department.php?edit=".$DID," return checkdepartmentform(this)",$Fields,$Button);

    }

}

?>
