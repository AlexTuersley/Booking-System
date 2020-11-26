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
            $this->startime = $row["starttime"];
            $this->end_time = $row["endtime"];
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
        $WQ = new WriteQuery("INSERT INTO staffschedule(staffid,staffday,starttime,endtime,active,away,deleted)
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
                              starttime = :starttime,
                              endtime = :endtime,
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
        $RQ = new ReadQuery("SELECT starttime, endtime, active, away, startdate, enddate FROM staffschedule WHERE staffid = :stid AND deleted = 0",
                                array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                            ));
        $timeslots = array();
        $holidays  = array();
        $counter = 0;
        $counter2 = 0;
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            $timeslots[$counter] = array($row["starttime"],$row["endtime"],$row["active"]);
            if($row["away"] > 0) {
                $holidays[$counter2] = array($row["starttime"],$row["startdate"],$row["endtime"],$row["enddate"],$row["active"],$row["away"]);
                $counter2++;
            }
            $counter++;
        }
        $slots = array($timeslots,$holidays);
        return $slots;
    }
    static public function showstaffschedule($ID){
        //Forms::generateaddbutton("Departments","schedule.php?department=","arrow-left","secondary");
    }
    static public function listdepartmentstaff($DID){
        if($_SESSION["userlevel"] == 1){
            print("<p class='welcome'>The list below shows all Staff within this Department. Click on a Staff member to see their schedule.</p>");
            Forms::generateaddbutton("Departments","schedule.php","arrow-left","secondary");
            $RQ = new ReadQuery("SELECT * FROM users JOIN userinformation ON users.id = userinformation.userid WHERE userinformation.department = :department", array(
                PDOConnection::sqlarray(":department",$DID,PDO::PARAM_INT)
            ));
            $Rows = array();
            $RowCounter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Row1 = array("<a href=?staff=".$row["id"].">".$row["fullname"]."</a>","button");
                $Row2 = array($row["email"]);
                $Rows[$RowCounter] = array($Row1,$Row2);
                $RowCounter++;
            }
            $Cols = array(array("Staff","department",1),array("Email","staff",1));

            Display::generatedynamiclistdisplay("staffdepartmenttable",$Cols,$Rows,"Staff",0);
                
        }
        else{
            print("<p class='banner-warning'>You are not a member of staff or an administrator. As such you do not have permission for this page, you will be redirected shortly.</p>");
            header("refresh:5;url=http://".BASEPATH."/index.php");
        }
    }
    static public function listdepartments(){
        
        if($_SESSION["userlevel"] == 1){
            print("<p class='welcome'>The list below shows all departments. Click on a Department to see the Staff members.</p>");
            $RQ = new ReadQuery("SELECT id,departmentname,(SELECT COUNT(*) FROM users JOIN userinformation ON users.id = userinformation.userid WHERE userinformation.department = departments.id) as staffcount FROM departments WHERE deleted = 0", null);
            $Rows = array();
            $RowCounter = 0;
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $Row1 = array("<a href=?department=".$row["id"].">".$row["departmentname"]."</a>","button");
                $Row2 = array($row["staffcount"]);
                $Rows[$RowCounter] = array($Row1,$Row2);
                $RowCounter++;
            }
            $Cols = array(array("Department","department",1),array("Number of Staff","staff",1));

            Display::generatedynamiclistdisplay("departmenttable",$Cols,$Rows,"Department",0);
                
        }
        else{
            print("<p class='banner-warning'>You are not a member of staff or an administrator. As such you do not have permission for this page, you will be redirected shortly.</p>");
            header("refresh:5;url=http://".BASEPATH."/index.php");
        }
    }
    static public function scheduleform($SID,$staff,$day,$starttime,$endtime,$active,$away,$startdate,$enddate){
        
    }

}


?>