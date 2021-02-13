<?php
Class MeetingType{

    //Class Variables
    private $id;
    private $name;
    private $staffid;
    private $description;
    private $duration;
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
    function getdescription(){
        return $this->description;
    }
    function setdescription($Val){
        $this->description = $Val;
    }
    function getstaffid(){
        return $this->staffid;
    }
    function setstaffid($Val){
        $this->staffid = $Val;
    }
    function getduration(){
        return $this->duration;
    }
    function setduration($Val){
        $this->duration = $Val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($Val){
        $this->deleted = $Val;
    }

    /**
     * If ID is passed to the Class then information is gathered from the server
     * @param int $ID
     */
    function __construct($ID = 0){
        if($ID > 0){
            $RQ = new ReadQuery("SELECT * FROM meetingtype WHERE id = :meetingid", array(
                PDOConnection::sqlarray(":meetingid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->name = $row["meetingname"];
            $this->description = $row["meetingdescription"];
            $this->staffid = $row["staffid"];
            $this->duration = $row["duration"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
    }
    
    /**
     * Puts new data into the database, using the get functions to gather the data
     */
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO meetingtype(meetingname,meetingdescription,staffid,duration,deleted)
                            VALUES(:meetingname,:meetingdescription,:staffid,:duration,0)",
                            array(
                                PDOConnection::sqlarray(":meetingname",$this->getname(),PDO::PARAM_STR),
                                PDOConnection::sqlarray(":meetingdescription",$this->getdescription(),PDO::PARAM_STR),
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":duration",$this->getduration(),PDO::PARAM_INT)
                            ));
        $this->id = $WQ->getinsertid();
    }

    /**
     * Updates a database row using the get functions to get the data and ID of the row
     */
    function save(){
        $WQ = new WriteQuery("UPDATE meetingtype SET
                              meetingname = :meetingname,
                              meetingdescription = :meetingdescription,
                              staffid = :staffid,
                              duration = :duration
                              WHERE id = :id",
                            array(
                                PDOConnection::sqlarray(":meetingname",$this->getname(),PDO::PARAM_STR),
                                PDOConnection::sqlarray(":meetingdescription",$this->getdescription(),PDO::PARAM_STR),
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":duration",$this->getduration(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":id",$this->getid(),PDO::PARAM_INT)
                            ));
    }

    /**
     * Checks form input, preventing invalid data from being added to the DB and calss the Form display function
     * @param int $MID - ID of a Meeting Type
     */
    static public function addedit($MID){
        $name = htmlspecialchars(filter_var($_POST["name"], FILTER_SANITIZE_STRING));
        $staffid = htmlspecialchars(filter_var($_POST["staff"], FILTER_SANITIZE_NUMBER_INT));
        $description = htmlspecialchars(filter_var($_POST["description"], FILTER_SANITIZE_STRING));
        $duration = htmlspecialchars(filter_var($_POST["duration"], FILTER_SANITIZE_NUMBER_INT));
        $Submit = $_POST["submit"];

        if($Submit){
            if($name != "" && $staffid > 0 && $duration > 0 && $duration < 121){
                if($MID > 0){
                    $MeetingType = new MeetingType($MID);
                    $MeetingType->setname($name);
                    $MeetingType->setdescription($description);
                    $MeetingType->setstaffid($staffid);
                    $MeetingType->setduration($duration);
                    if(MeetingType::checkmeetingname($MID,$name,$staffid)){
                        $MeetingType->save();
                        print("<p class='welcome alert alert-success'>The Meeting Type ".$name." has been edited</p>");
                    }
                }
                else{
                    $MeetingType = new MeetingType();
                    $MeetingType->setname($name);
                    $MeetingType->setdescription($description);
                    $MeetingType->setstaffid($staffid);
                    $MeetingType->setduration($duration);
                    if(MeetingType::checkmeetingname(0,$name,$staffid)){
                        $MeetingType->savenew();
                        print("<p class='welcome alert alert-success'>The Meeting Type ".$name." has been added</p>");
                    }         
                }
            }

            else{
                $StaffError = array("stafferror", "Please select a valid Staff Member");
                $DurationError = array("durationerror","Please enter a valid Duration");
                $NameError = array("nameerror","Please enter a valid Name for the Meeting");
                $Errors = array($StaffError,$NameError,$DurationError);
                Forms::generateerrors("Please correct the following errors before continuing.",$Errors,$Submit);
            }
           
        }
        if($MID > 0){
            $Meeting = new MeetingType($MID);
            MeetingType::meetingform($MID,$Meeting->getname(),$Meeting->getstaffid(),$Meeting->getdescription(),$Meeting->getduration());
        }
        else{
            MeetingType::meetingform($MID,$name,$staffid,$description,$duration);
        }
    }

    /**
     * Checks if a Meeting exists with a Name already, if so returns false
     * @param int $MID - Id of the Meeting Type
     * @param string $name - Name of the Meeting Type
     * @param int $STID -  Id of the staff member associated with the Meeting Type
     * @return bool 
     */
    static public function checkmeetingname($MID, $name, $STID){
        $RQ = new ReadQuery("SELECT meetingname FROM meetingtype WHERE meetingname = :meetingname AND deleted = 0 AND id != :id AND staffid = :staffid",array(
            PDOConnection::sqlarray(":meetingname",$name,PDO::PARAM_STR),
            PDOConnection::sqlarray(":id",$MID,PDO::PARAM_INT),
            PDOConnection::sqlarray(":staffid",$STID,PDO::PARAM_INT)
        ));
        if($RQ->getnumberofresults() > 0){
            print("<p class='alert alert-warning'><strong>Meeting Exists </strong>A Meeting with this name already exists for your user. Please edit it if you wish to make changes</p>");       
            return false;
        }
        return true;
    }

    /**
     * Returns the name of Meeting Type
     * @param int $MID - Id of the Meeting Type
     * @return string The name of the Meeting Type or a string saying it doesn't exist
     */
    static public function getmeetingnamestatic($MID){
        $RQ = new ReadQuery("SELECT meetingname FROM meetingtype WHERE id = :id AND deleted = 0",array(
            PDOConnection::sqlarray(":id",$MID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            return $row["meetingname"];
        }
        return "Meeting Type doesn't exist";
    }
    
    /**
     * Displays Meetings Types associated with a Staff Member for Students, each one contains a link to the Booking Calendar
     * @param int $STID - Id of the Staff Member
     * @param int $DID - Id of the Department the Staff Member is associated with
     */
    static public function showmeetingtypes($STID,$DID){
        $RQ = new ReadQuery("SELECT id,meetingname,meetingdescription,duration FROM meetingtype WHERE staffid = :stid AND deleted = 0 ORDER BY meetingname",
                    array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
        ));
       
        if($RQ->getnumberofresults() > 0){
            print("<p class='welcome'>Please select the type of Meeting you would like to arrange</p>");
            Forms::generatebutton("Staff","schedule.php?department=".$DID,"arrow-left","secondary");
            $count = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Description = "";
                if($row['meetingdescription'] != ""){
                    $Description =  "<p>Description: ".$row['meetingdescription']."</p>";
                }
                if($count%2 == 0){
                    print("<div class='row'>
                    <div class='col-6'>
                    <div class='item'>
                    <h3><a href='schedule.php?department=".$DID."&staff=".$STID."&type=".$row['id']."'>".$row['meetingname']."</a></h3>
                    <p style='margin-bottom:auto;'>Duration: ".$row['duration']." Minutes</p>
                    ".$Description."
                    </div>
                    </div>");
                }
                else{
                    print("<div class='col-6'>
                    <div class='item'>
                    <h3><a href='schedule.php?department=".$DID."&staff=".$STID."&type=".$row['id']."'>".$row['meetingname']."</a></h3>
                    <p style='margin-bottom:auto;'>Duration: ".$row['duration']." Minutes</p>
                    ".$Description."
                    </div>
                    </div>
                    </div>");
                }
               
                $count++;
            }
        }
        else{
            $RQ2 = new ReadQuery("SELECT * FROM users JOIN userinformation ON users.id = userinformation.userid WHERE id = :stid",array(
                PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
            ));
            if($row2 = $RQ2->getresults()->fetch(PDO::FETCH_BOTH)){
                $Phone = "";
                $Location = "";
                if($row2['phone'] > 0){
                    $Phone = "<p>Phone: ".$row2['phone']."</p>";
                }
                if($row2['location']){
                    $Location = "<p>Location: ".$row2['location']."</p>";
                }
                Forms::generatebutton("Staff","schedule.php?department=".$DID,"arrow-left","secondary");
                print("<div class='welcome'>
                       <p>".$row2['username']." has not setup their meetings.</p>
                       <p>Their contact information is listed below if you wish to inform them</p>
                       <p>Email: ".$row2['email']."</p>
                       ".$Phone."
                       ".$Location."
                       </div>");
            }
        }
    
    }

    /**
     * Displays all of the Meeting Types associated with a Staff member in a table format. 
     * This allows the user to add, edit and delete Meeting Types
     * @param int $STID - Id of the Staff Member
     */
    static public function listmeetingtypes($STID){
        if($STID){
                Forms::generatebutton("Add Meeting Type","meetingtype.php?edit=-1","plus","primary","","","Click this button to add a new Meeting Type");
                Forms::generatebutton("Show Schedule","schedule.php","calendar-alt","primary","","","Click this button to show the time slots in your schedule");
                Forms::generatebutton("Show Holidays","schedule.php?away=1","plane","primary","","","Click this button to show your holidays");
             
                $RQ = new ReadQuery("SELECT id, meetingname, duration FROM meetingtype WHERE staffid = :stid AND deleted = 0 ORDER BY meetingname",
                    array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                ));
                $Rows = array();
                $RowCounter = 0;
                $Cols = array(array("Name","name",1),array("Duration","duration",1),array("","functions",2));
                while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $Row1 = array($row['meetingname']);
                    $Row2 = array($row['duration']);
                    $Row3 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit Meeting Type'></i></a>","button");
                    $Row4 = array("<a href='?remove=". $row["id"] ."'><i class='fas fa-trash-alt' title='Delete Meeting Type'></i></a>","button");
                    $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4);
                    $RowCounter++;
                }
                print("<p class='welcome'>List of Meeting Types for ". $_SESSION["username"]."</p>");
                Display::generatedynamiclistdisplay("staffmeetingstable",$Cols,$Rows,"name",0);
        } 
    }

    /**
     * Set a Meeting Type to Deleted - remains in the DB but can't be edited or deleted
     */
    static public function deletemeetingtype($ID){
        $WQ = new WriteQuery("UPDATE meetingtype SET deleted = 1 WHERE id = :id",array(
            PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
        ));
        print("<p class='alert alert-success'>Meeting Type has successfully been deleted</p>");
    }

    /**
     * Displays a Form with inputs to do set up or edit a Meeting Type
     * @param int $MID - Id of the Meeting Type
     * @param string $name - Name of the Meeting Type
     * @param int $staffid - Id of the Staff member
     * @param string $description - Description of the Meeting Type
     * @param int - $duration - how long the Meeting will be
     */
    static public function meetingform($MID,$name,$staffid,$description,$duration){
        Forms::generatebutton("Meeting Types","meetingtype.php","arrow-left","secondary");
        $StaffArray = array(array($_SESSION['userid'],$_SESSION['username']));
        $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray);
        $NameField = array("Meeting Name: ","Text","name",30,$name,"Name of the Meeting Type","","","","Enter a Name for the Meeting Type");
        $DescriptionField = array("Description: ","TextArea","description",4,$description,"Enter a Description for the Meeting Type","","","","Details about the type of meeting e.g. Project Tutorial");
        $DurationField = array("Duration (In minutes):", "NumberText","duration",30,$duration,"","","","","Duration of the Meeting Type e.g. 30 mins","",5,120,5);
        $Fields= array($StaffField,$NameField,$DescriptionField,$DurationField);
        if($MID > 0){
            $Button = "Edit Meeting Type";
        }
        else{
            $Button = "Add Meeting Type";
        }
        Forms::generateform("Meeting Type","meetingtype.php?edit=".$MID,"return checkmeetingform(this)",$Fields,$Button);
       
    }
}

?>