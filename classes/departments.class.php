<?php
Class Departments{

    //Class Variables
    private $id;
    private $name;
    private $deleted;

    //get and set functions
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

    //Gets information about the Department if an $ID passed through is > 0 
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

    //Saves a new Department into the DB using get functions
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO departments(departmentname,deleted)VALUES(:departmentname,0)",array(
                                PDOConnection::sqlarray(":departmentname",$this->getname(),PDO::PARAM_STR)
                            ));
    }

    //Updates a Department in the DB using get functions
    function save(){
        $WQ = new WriteQuery("UPDATE departments SET departmentname = :departmentname WHERE id = :id",array(
                PDOConnection::sqlarray(":departmentname",$this->getname(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":id",$this->getid(),PDO::PARAM_INT)
    ));
    }

    /**
     * Function sets the Department to Deleted - can be recovered by an Admin in the DB
     * @param int $DID - Id of the Department
     */
    static public function delete($DID){
        $RQ = new ReadQuery("SELECT * FROM userinformation WHERE department = :department",array(
            PDOConnection::sqlarray(":department",$DID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getnumberofresults() > 0){
            print("<p class='welcome alert alert-warning'>The Department has been not deleted. There are Users still within this Department.</p>");
            return false;
        }
        else{
            $WQ = new WriteQuery("UPDATE departments SET deleted = 1 WHERE id = :id",array(
                PDOConnection::sqlarray(":id",$DID,PDO::PARAM_INT)
            ));
            print("<p class='welcome alert alert-success'>The Department has been deleted</p>");
        }
        return true;

    }

    /**
     * Function adds and edits Departments in the DB based on form input
     * @param int $DID - ID of the Department
     */
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
                    print("<p class='welcome alert alert-success'>The Department ".$name." has been edited</p>");   
                }
                else{
                    $Department = new Departments();
                    $Department->setname($name);
                    $Department->savenew();
                    print("<p class='welcome alert alert-success'>The Department ".$name." has been added</p>");   
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

    //If the User is logged in displays a List of clickable Departments
    static public function listdepartments(){
        if($_SESSION["userlevel"] >= 1){
            $RQ = new ReadQuery("SELECT id FROM departments WHERE deleted = 0", null);
            print("<p class='welcome'>The list below shows all departments</p><p class='welcome'>Click on a department to see the staff inside and select a staff member for bookings</p>");
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

    //Displays all the Departments in the DB in a table if the User's level is Admin
    static public function listdepartmentsadmin(){
           if($_SESSION["userlevel"] >= 3){
            $RQ = new ReadQuery("SELECT * FROM departments WHERE deleted = 0", null);
            print("<p class='welcome'>The list below shows all departments</p>");
            Forms::generatebutton("Add Department","department.php?edit=-1","plus","primary","","","Click this button to add new Departments");
            $Rows = array();
            $RowCounter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Row1 = array($row["departmentname"]);
                $Row2 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit ".$row["department"]."'></i></a>","button");
                $Row3 = array("<a href='?remove=". $row["id"] ."'><i class='fas fa-trash-alt' title='Delete ".$row["departmentname"]."'></i></a>","button");
                $Rows[$RowCounter] = array($Row1,$Row2,$Row3);
                $RowCounter++;
            }
            $Cols = array(array("Department","department",1),array("","functions",2));

            Display::generatedynamiclistdisplay("admindepartmenttable",$Cols,$Rows,"Department",0);
        }
        else{
            print("<p class='welcome'>You do not have permission to view this page. Redirecting to home</p>");
        }
    }

    /**
     * Generates an array of all the Departments in the DB
     * @return array $ReturnArray - array of all the Departments in the DB
     */
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
    /**
     * Uses the Forms class and variables to generate a HTML form
     * @param int $DID - ID of the Department
     * @param string $name - name of the Department
     */
    static public function departmentform($DID,$name){
        Forms::generatebutton("Departments","department.php","arrow-left","secondary");
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
