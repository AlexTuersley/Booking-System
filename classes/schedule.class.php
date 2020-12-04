<?php


class Schedule {

    //Class Variables
    private $id;
    private $staffid;
    private $day;
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
    function getday(){
        return $this->day;
    }
    function setday($Val){
        $this->day = $Val;
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

    function __construct($ID = 0){
        if($ID > 0){

            $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE id = :staffscheduleid", array(
                PDOConnection::sqlarray(":staffscheduleid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->staffid = $row["staffid"];
            $this->day = $row["day"];
            $this->start_time = $row["starttime"];
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
        $WQ = new WriteQuery("INSERT INTO staffschedule(staffid,staffday,starttime,endtime,active,away,startdate,enddate,deleted)
                            VALUES(:staffid,:staffday,:starttime,:endtime,:active,:away,:startdate,:enddate,0)",
                              array(
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":staffday",$this->getday(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":active",$this->getactive(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":away",$this->getaway(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":startdate",$this->getstartdate(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":enddate",$this->getenddate(), PDO::PARAM_STR)
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
                              startdate = :startdate,
                              enddate = :enddate
                              WHERE id = :id
                              ",
                              array(
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":staffday",$this->getday(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":active",$this->getactive(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":away",$this->getaway(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":startdate",$this->getstartdate(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":enddate",$this->getenddate(), PDO::PARAM_STR),
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
        $awayget = $_GET['away'];
        $staffid = filter_var($_POST["staff"], FILTER_SANITIZE_NUMBER_INT);
        $day = filter_var($_POST["day"], FILTER_SANITIZE_NUMBER_INT);
        $starttime = $_POST["starttime"];
        $endtime = $_POST["endtime"];
        $active = filter_var($_POST["active"], FILTER_SANITIZE_NUMBER_INT);
        $away = filter_var($_POST["away"], FILTER_SANITIZE_NUMBER_INT);
        $startdate = $_GET["startdate"];
        $enddate = $_GET["enddate"];
        $Submit =$_POST["submit"];

        if($Submit){
            if($SID > 0){
                $Schedule = new Schedule($SID);         
                $Schedule->setstarttime($starttime);
                $Schedule->setendtime($endtime);
                if($away > 0){
                    $Schedule->setday(0);
                    $Schedule->setaway($away);
                    $Schedule->setactive(0);
                    $Schedule->setstartdate($startdate);
                    $Schedule->setenddate($enddate);
                }
                else{
                    $Schedule->setday($day);
                    $Schedule->setaway(0);
                    $Schedule->setactive($active);
                }
                $Schedule->save();
            }
            else{
                $Schedule = new Schedule();
                $Schedule->setstaffid($staffid);
              
                $Schedule->setstarttime($starttime);
                $Schedule->setendtime($endtime);
                if($away > 0){
                    $Schedule->setday(0);
                    $Schedule->setaway($away);
                    $Schedule->setactive(0);
                    $Schedule->setstartdate($startdate);
                    $Schedule->setenddate($enddate);
                }
                else{
                    $Schedule->setday($day);
                    $Schedule->setaway(0);
                    $Schedule->setactive($active);
                }
                $Schedule->setdeleted(0);
                $Schedule->savenew();
            }
          
        }
        if($SID > 0){
            $Schedule = new Schedule($SID);
            Schedule::scheduleform($SID,$Schedule->getstaffid(),$Schedule->getday(),$Schedule->getstarttime(),$Schedule->getendtime(),
                                   $Schedule->getactive(),$Schedule->getaway(),$Schedule->getstartdate(),$Schedule->getenddate());
        }
        else{
            if($awayget){
                Schedule::scheduleform($SID,$staffid,$day,$starttime,$endtime,$active,1,$startdate,$enddate);    
            }
            else{
                Schedule::scheduleform($SID,$staffid,$day,$starttime,$endtime,1,$away,$startdate,$enddate);
            }
            
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
    static public function getstaffday($day){
        switch($day){
            case 1:
                return "Monday";
                break;
            case 2:
                return "Tuesday";
                break;
            case 3:
                return "Wednesday";
                break; 
            case 4:
                return "Thursday";
                break; 
            case 5:
                return "Friday";
                break;  
            case 6:
                return "Saturday";
                break;          
            case 1:
                return "Sunday";
                break; 
            default:
                return "N/A";
            break;
        }

    }
    static public function liststaffschedule($STID, $holiday = 0){
        if($STID){
          
            if($holiday){
                Forms::generateaddbutton("Add Holiday","schedule.php?edit=-1&away=1","plus","primary","","","Click this button to add a new Holiday");
                Forms::generateaddbutton("Show Schedule","schedule.php","calendar-alt","primary","","","Click this button to show the time slots in your schedule");
                $RQ = new ReadQuery("SELECT id, starttime, endtime, startdate, enddate FROM staffschedule WHERE staffid = :stid AND away = 1 AND deleted = 0",
                                array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                ));
                $Rows = array();
                $RowCounter = 0;
                $Cols = array(array("Start","start",1),array("End","end",1),array("","functions",2));
                while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $Row1 = array($row['starttime'].$row['startdate']);
                    $Row2 = array($row['endtime'].$row['enddate']);
                    $Row3 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit Holiday'></i></a>","button");
                    $Row4 = array("<a href='?remove=". $row["id"] ."'><i class='fas fa-trash-alt' title='Delete Holiday'></i></a>","button");
                    $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4);
                    $RowCounter++;
                }
                print("<p>List of holidays for ". $_SESSION["username"]."</p>");
                Display::generatedynamiclistdisplay("staffholidaytable",$Cols,$Rows,"Start Date",0);

            }
            else{
                Forms::generateaddbutton("Add Schedule","schedule.php?edit=-1&active=1","plus","primary","","","Click this button to add a new Slot in your Schedule");
                Forms::generateaddbutton("Show Holidays","schedule.php?away=1","plane","primary","","","Click this button to show your holidays");
               
                $RQ = new ReadQuery("SELECT id, staffday, starttime, endtime FROM staffschedule WHERE staffid = :stid AND active = 1 AND deleted = 0 ORDER BY staffday",
                    array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                ));
                $Rows = array();
                $RowCounter = 0;
                $Cols = array(array("Day","day",1),array("Start Time","starttimme",1),array("End Time","endtime",1),array("","functions",2));
                while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $Row1 = array(Schedule::getstaffday($row['staffday']));
                    $Row2 = array($row['starttime']);
                    $Row3 = array($row['endtime']);
                    $Row4 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit Holiday'></i></a>","button");
                    $Row5 = array("<a href='?remove=". $row["id"] ."'><i class='fas fa-trash-alt' title='Delete Holiday'></i></a>","button");
                    $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4,$Row5);
                    $RowCounter++;
                }
                print("<p>List of slots available for ". $_SESSION["username"]."</p>");
                Display::generatedynamiclistdisplay("staffscheduletable",$Cols,$Rows,"Day",0);
            }
           

        }
    }
    static public function jsonstaffschedule($UID){
        if($UID > 0){
            $RQ = new ReadQuery("SELECT id, staffday, starttime, endtime FROM staffschedule WHERE staffid = :id AND active = 1 AND deleted = 0 ORDER BY staffday, starttime",array(
                PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
            ));
            $schedule_json = array();
            $i = 0;
            while ($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                $schedule_json[$i] = array(
                    'id' => $row['id'],
                    'staffday' => $row['staffday'],
                    'start' => $row['starttime'],
                    'end' => $row['endtime']
                );
                $i++;
            }
            print_r(json_encode($schedule_json));
        }
    }
    static public function showstaffschedule($ID){
        //Forms::generateaddbutton("","schedule.php?department=","arrow-left","secondary");
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
        if($active == 1){
            Forms::generateaddbutton("Schedule","schedule.php","arrow-left","secondary");
        }
        else{
            Forms::generateaddbutton("Schedule","schedule.php?away=1","arrow-left","secondary");
        }
       
       $StaffArray = array(array($_SESSION['userid'],$_SESSION['username']));
       $staff = $_SESSION['userid'];
       if($away > 0){
            $AwayField = array("Away: ","Text","away",30,$away);
            $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray);
            $StartField = array("Start Time: ","Time","starttime",10,$starttime,"Select the start time");
            $EndField = array("End Time: ","Time","endtime",10,$endtime,"Select the end time");
            $StartDateField = array("Start Date: ","Date","startdate",10,$startdate,"Select the start date");
            $EndDateField = array("End Date: ","Date","enddate",10,$enddate,"Select the end date");
            $Fields = array($AwayField,$StaffField,$StartField,$EndField,$DayField,$StartDateField,$EndDateField);
            if($SID > 0){
                $Button = "Edit Holiday";
            }
            else{
                $Button = "Add Holiday";
            }
            $Path = "schedule.php?edit=".$SID."&holiday=1";
        }
        else{
            $DayArray = array(array(1,"Monday"),array(2,"Tuesday"),array(3,"Wednesday"),array(4,"Thursday"),array(5,"Friday"));
            $ActiveField = array("Active: ","Text","active",30,$active,"","","readonly");
            $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray,"","readonly");
            $DayField = array("Day:","Select","day",30,$day,"Select the day you want to add this schedule",$DayArray,"","","Select a day to add this schedule to e.g. Monday");
            $StartField = array("Start Time: ","Time","starttime",10,$starttime,"Select the start time");
            $EndField = array("End Time: ","Time","endtime",10,$endtime,"Select the end time");
            $Fields = array($ActiveField,$StaffField,$DayField,$StartField,$EndField);
            if($SID > 0){
                $Button = "Edit Schedule";
            }
            else{
                $Button = "Add Schedule";
            }
            $Path = "schedule.php?edit=".$SID."&active=1";
        }
      
        Forms::generateform("Schedule",$Path,"",$Fields,$Button);
    }

}


?>