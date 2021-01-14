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
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO meetingtype(meetingname,meetingdescription,staffid,duration,deleted)
                            VALUES(:meetingname,:meetingdescription,:staffid,:duration,0)",
                            array(
                                PDOConnection::sqlarray(":meetingname",$this->getname(),PDO::PARAM_STR),
                                PDOConnection::sqlarray(":meetingdescription",$this->getdescription(),PDO::PARAM_STR),
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":duration",$this->getduration(),PDO::PARAM_INT),
                            ));
        $this->id = $WQ->getinsertid();
    }
    function save(){
        $WQ = new WriteQuery("UPDATE meetings SET
                              meetingname = :meetingname,
                              meetingdescription = :meetingdescription
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

    static public function addedit($MID){
        $name = htmlspecialchars(filter_var($_POST["name"], FILTER_SANITIZE_STRING));
        $staffid = htmlspecialchars(filter_var($_POST["staff"], FILTER_SANITIZE_NUMBER_INT));
        $description = htmlspecialchars(filter_var($_POST["description"], FILTER_SANITIZE_STRING));
        $duration = htmlspecialchars(filter_var($_POST["duration"], FILTER_SANITIZE_NUMBER_INT));
        $Submit = $_POST["submit"];

        if($Submit){
            if($MID > 0){
                $MeetingType = new MeetingType($MID);
                $MeetingType->setname($name);
                $MeetingType->setdescription($description);
                $MeetingType->setstaffid($staffid);
                $MeetingType->setduration($duration);
                $MeetingType->save();
                print("<p class='welcome alert alert-success'>The Meeting Type ".$name." has been edited</p>");
            }
            else{
                $MeetingType = new MeetingType();
                $MeetingType->setname($name);
                $MeetingType->setdescription($description);
                $MeetingType->setstaffid($staffid);
                $MeetingType->setduration($duration);
                $MeetingType->savenew();
                print("<p class='welcome alert alert-success'>The Meeting Type ".$name." has been added</p>");   
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
    //Display selectable meeting types for student users
    static public function showmeetingtypes($STID){

    }
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
    static public function deletemeetingtype($ID){
        $WQ = new WriteQuery("UPDATE meetingtype SET deleted = 1 WHERE id = :id",array(
            PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
        ));
        print("<p class='alert alert-success'>Meeting Type has successfully been deleted</p>");
    }
    static public function meetingform($MID,$name,$staffid,$duration){
        Forms::generatebutton("Meeting Types","meetingtype.php","arrow-left","secondary");
        $StaffArray = array(array($_SESSION['userid'],$_SESSION['username']));
        $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray);
        $NameField = array("Meeting Name: ","Text","name",30,$name,"Name of the Meeting Type","","","","Enter a Name for the Meeting Type");
        $DescriptionField = array("Description: ","TextArea","description",4,$description,"Enter a Description for the Meeting Type","","","","Details about the type of meeting e.g. Project Tutorial");
        $DurationField = array("Duration (In minutes):", "NumberText","duration",30,$duration,5,"","","","Duration of the Meeting Type e.g. 30 mins","",5,120,5);
        $Fields= array($StaffField,$NameField,$DescriptionField,$DurationField);
        if($MID > 0){
            $Button = "Edit Meeting Type";
        }
        else{
            $Button = "Add Meeting Type";
        }
        Forms::generateform("Meeting Type","meetingtype.php?edit=".$MID,"",$Fields,$Button);
       
    }
}

?>