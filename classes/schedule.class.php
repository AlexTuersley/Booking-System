<?php


class Schedule {

    //Class Variables
    private $id;
    private $staffid;
    private $date;
    private $start_time;
    private $end_time;
    private $active;
    private $away;
    private $start_date;
    private $end_date;
    private $deleted;

    //getter and setter functions
    function getid(){
        return $this->id;
    }
    function setid($Val){
        $this->id = $Val;
    }
    function getstaffid(){
        return $this->staffid;
    }
    function setstaffid($Val){
        $this->staffid = $Val;
    }
    function getdate(){
        return $this->date;
    }
    function setdate($Val){
        $this->date = $Val;
    }
    function getstarttime(){
        return $this->start_time;
    }
    function setstarttime($Val){
        $this->start_time = $Val;
    }
    function getendtime(){
        return $this->end_time;
    }
    function setendtime($Val){
        $this->end_time = $Val;
    }
    function getactive(){
        return $this->active;
    }
    function setactive($Val){
        $this->active = $Val;
    }
    function getaway(){
        return $this->away;
    }
    function setaway($Val){
        $this->away = $Val;
    }
    function getstartdate(){
        return $this->start_date;
    }
    function setstartdate($Val){
        $this->start_date = $Val;
    }
    function getenddate(){
        return $this->end_date;
    }
    function setenddate($Val){
        $this->end_date = $Val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($Val){
        $this->deleted = $Val;
    }

    function __construct(){
        if($ID > 0){

            $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE id = :staffscheduleid", array(
                PDOConnection::sqlarray(":staffscheduleid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->staffid = $row["staffid"];
            $this->day = $row["day"];
            $this->startime = $row["start_time"];
            $this->end_time = $row["end_time"];
            $this->active = $row["active"];
            $this->away = $row["away"];
            $this->start_date = $row["startdate"];
            $this->end_date = $row["enddate"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
    }
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO staffschedule(staffid,staffday,start_time,end_time,active,away,deleted)
                            VALUES(:staffid,staffday,starttime,endtime,active,away,0)",
                              array(
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":staffday",$this->getday(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":starttime",$this->getstarttime()->getdatabasedatetime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":endtime",$this->getendtime()->getdatabasedatetime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":active",$this->getactive(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":away",$this->getnote(),PDO::PARAM_INT)
        ));
    }
    function save(){
        $WQ = new WriteQuery("UPDATE staffschedule SET
                              staffid = :staffid,
                              staffday = :staffday,
                              start_time = :starttime,
                              end_time = :endtime,
                              active = :active,
                              away = :away,
                              deleted = :deleted
                              WHERE id = :id
                              ",
                              array(
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":staffday",$this->getday(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":starttime",$this->getstarttime()->getdatabasedatetime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":endtime",$this->getendtime()->getdatabasedatetime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":active",$this->getactive(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":away",$this->getnote(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":id", $this->getid(),PDO::PARAM_INT)
        ));
                               
    }
    //add new schedule item
    public function addnewschedule(){

    }
    //edit schedule item
    public function editschedule(){

    }
    //make item a holiday(away)
    public function makescheduleholiday(){

    }
    //make item active(show on timetable)
    public function activatescheduleitem(){
        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    public function addedit($SID){
        $staffid = $_GET["staffid"];
        $day = $_GET["day"];
        $starttime = $_GET["starttime"];
        $endtime = $_GET["endtime"];
        $active = $_GET["active"];
        $away = $_GET["away"];
        $startdate = $_GET["startdate"];
        $enddate = $_GET["enddate"];

        if($SID > 0){
            $Schedule = new Schedule($SID);
            $Schedule->setday($day);
            $Schedule->setstarttime($starttime);
            $Schedule->setendtime($endtime);
            $Schedule->setactive($active);
            $Schedule->setaway($away);
            if($away > 0){
                $Schedule->setstartdate(NULL);
                $Schedule->setenddate(NULL);
            }
            $Schedule->save();
        }
        else{
            $Schedule = new Schedule();
            $Schedule->setstaffid($staffid);
            $Schedule->setday($day);
            $Schedule->setstarttime($starttime);
            $Schedule->setendtime($endtime);
            $Schedule->setactive($active);
            $Schedule->setaway($away);
            if($away > 0){
                $Schedule->setstartdate($startdate);
                $Schedule->setenddate($enddate);
            }
            else{
                $Schedule->setstartdate(NULL);
                $Schedule->setenddate(NULL);
            }
            $Schedule->setdeleted(0);
            $Schedule->savenew();
        }
    }
    static public function deleteschedule($SID){
        $WQ = new WriteQuery("UPDATE staffschedule SET deleted = 1 WHERE id = :id",
            array(PDOConnection::sqlarray(":id",$SID,PDO::PARAM_INT))
        );
    }
    static public function listuserslots($STID){
        $RQ = new ReadQuery("SELECT start_time, end_time, active, away, startdate, enddate FROM staffschedule WHERE staffid = :stid AND deleted = 0",
                                array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                            ));
        $timeslots = array();
        $holidays  = array();
        $counter = 0;
        $counter2 = 0;
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            $timeslots[$counter] = array($row["start_time"],$row["end_time"],$row["active"]);
            if($row["away"] > 0) {
                $holidays[$counter2] = array($row["start_time"],$row["startdate"],$row["end_time"],$row["enddate"],$row["active"],$row["away"]);
                $counter2++;
            }
            $counter++;
        }
        $slots = array($timeslots,$holidays);
        return $slots;
    }
    static public function listuserdepartments(){
        if($_SESSION["userlevel"] == 1){
            $RQ = new ReadQuery("SELECT id,departmentname FROM departments WHERE deleted = 0");
            $UserDepartmentArray = array();
            $UserDepartmentCounter = 0;
            $DepartmentArray = array();
            $DepartmentCounter = 0;
            $UserArray = array();
            $Counter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $DepartmentArray[$Counter] = $row["departmentname"];
                $RQ2 = new ReadQuery("SELECT id, fullname FROM users JOIN userinformation ON users.id = userinformation.userid WHERE userinformation.department = :department",array(
                    PDOConnection::sqlarray(":department",$row["id"],PARAM_INT)
                ));
                while($row2 = $RQ2->getresults()->fetch(PDO::FETCH_BOTH)){
                    $UserArray[$Counter] = array($row2["id"],$row2["fullname"]);
                    $Counter++;
                }
                
                $UserDepartmentArray[$UserDepartmentCounter] = array($DepartmentArray,$UserArray);
                $DepartmentCounter++;
                $UserDepartmentCounter++;
            }
            
        }
        else{
            print("You are not a student. As such you do not have permission for this page, you will be redirected shortly.");
            header("Location: http://".BASEPATH."/index.php");
        }
    }
    static public function scheduleform($SID,$staff,$day,$starttime,$endtime,$active,$away,$startdate,$enddate){
        
    }

}


?>