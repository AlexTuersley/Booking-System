<?php

date_default_timezone_set('Europe/London');

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
        if(!$this->getstartdate()){
            $SD = NULL;
        }
        else{
            $SD = $this->getstartdate();
        }
        if(!$this->getenddate()){
            $ED = NULL;
        }   
        else{
            $ED = $this->getenddate();
        }
        $WQ = new WriteQuery("INSERT INTO staffschedule(staffid,staffday,starttime,endtime,active,away,startdate,enddate,deleted)
                            VALUES(:staffid,:staffday,:starttime,:endtime,:active,:away,:startdate,:enddate,0)",
                              array(
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":staffday",$this->getday(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
                                PDOConnection::sqlarray(":active",$this->getactive(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":away",$this->getaway(),PDO::PARAM_INT),
                                PDOConnection::sqlarray(":startdate",$SD,PDO::PARAM_STR),
                                PDOConnection::sqlarray(":enddate",$ED,PDO::PARAM_STR)
        ));
    }
    function save(){
        if(!$this->getstartdate()){
            $SD = NULL;
        }
        else{
            $SD = $this->getstartdate();
        }
        if(!$this->getenddate()){
            $ED = NULL;
        }   
        else{
            $ED = $this->getenddate();
        }
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
                                PDOConnection::sqlarray(":startdate",$SD,PDO::PARAM_STR),
                                PDOConnection::sqlarray(":enddate",$ED,PDO::PARAM_STR),
                                PDOConnection::sqlarray(":id", $this->getid(),PDO::PARAM_INT)
        ));
                               
    }
    // function getdatabasedate(){

    // }

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
        $startdate = $_POST["startdate"];
        $enddate = $_POST["enddate"];
        $Submit =$_POST["submit"];

        if($Submit){
            if($startdate != NULL){
                $startdate = new DateTime($startdate);
            }
            if($enddate != NULL){
                $enddate = new DateTime($enddate);
            }
           
            if($SID > 0){
                $Schedule = new Schedule($SID);         
                $Schedule->setstarttime($starttime);
                $Schedule->setendtime($endtime);
                if($away > 0){
                    $Schedule->setday(0);
                    $Schedule->setaway($away);
                    $Schedule->setactive(0);
                    $Schedule->setstartdate($startdate->format('Y-m-d'));
                    $Schedule->setenddate($enddate->format('Y-m-d'));
                    $Schedule->save();
                }
                else{
                    $Schedule->setday($day);
                    $Schedule->setaway(0);
                    $Schedule->setactive($active);
                    if(Schedule::checkstaffdayslot($SID,$day,$starttime,$endtime,$staffid)){
                        $Schedule->save();
                    }
                }
               
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
                    $Schedule->setstartdate($startdate->format('Y-m-d'));
                    $Schedule->setenddate($enddate->format('Y-m-d'));
                    $Schedule->setdeleted(0);
                    $Schedule->savenew();
                }
                else{
                    $Schedule->setday($day);
                    $Schedule->setaway(0);
                    $Schedule->setactive($active);
                    if(Schedule::checkstaffdayslot(-1,$day, $starttime,$endtime,$staffid)){
                        $Schedule->setdeleted(0);
                        $Schedule->savenew();
                    }
                }               
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
        print("<p class='alert alert-success'>Schedule has successfully been deleted</p>");
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
    static public function checkstaffdayslot($id,$day,$starttime,$endtime,$userid){
        $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE staffday = :staffday AND id != :id AND staffid = :staff AND deleted = 0 AND (starttime BETWEEN :starttime AND :endtime OR endtime BETWEEN :starttime AND :endtime)",array(
            PDOConnection::sqlarray(':staffday',$day,PDO::PARAM_INT),
            PDOConnection::sqlarray(':id',$id,PDO::PARAM_INT),
            PDOConnection::sqlarray(':staff',$userid,PDO::PARAM_INT),
            PDOConnection::sqlarray(':starttime',$starttime,PDO::PARAM_STR),
            PDOConnection::sqlarray(':endtime',$endtime,PDO::PARAM_STR)
        ));
        if($RQ->getnumberofresults() > 0){
            print("<p class='alert alert-warning'><strong>Schedule Exists</strong> A schedule slot exists between these times on this day. Please select a different time slot.</p>");
            return false;
        }
        return true;

    }

    static public function checkholidayslot($id,$startdate, $enddate,$userid){
        $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE deleted = 0 id != :id AND staffid = :staff AND startdate BETWEEN :startdate AND :enddate OR enddate BETWEEN :startdate AND :enddate",array(
            PDOConnection::sqlarray(':id',$id,PDO::PARAM_INT),
            PDOConnection::sqlarray(':staff',$userid,PDO::PARAM_INT),
            PDOConnection::sqlarray(':startdate',$startdate,PDO::PARAM_STR),
            PDOConnection::sqlarray(':enddate',$enddate,PDO::PARAM_STR)
        ));
        if($RQ->getnumberofresults() > 0){
            print("<p class='alert alert-warning'><strong>Holiday Exists</strong>A holiday exists between these dates. Please edit or delete the holiday before adding a new one.</p>");
            return false;
        }
        return true;
    }
    static public function getstaffname($ID){
        $RQ = new ReadQuery("SELECT fullname FROM userinformation WHERE userid = :id",
        array(
            PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
          return $row["fullname"];
        }
        return false;
    }
    static public function liststaffavailability($ID){
        if($ID){
            if(Schedule::listuserslots($ID)){
                $name = Schedule::getstaffname($ID);
                if($name){
                    print("<p class='welcome'>Availability for ".$name."</p>
                    <div id='picker'></div>");
                    //Pass the availability through to the calendar
                    //Make sure can only go forward in dates and not backwards
                    //Availability should only show if does not interfere with a booking
                    //
                    ?>
        <script type="text/javascript">
        (function($) {
          $('#picker').markyourcalendar({
            availability: [
              ['1:00', '2:00', '3:00', '4:00', '5:00'],
              ['2:00'],
              ['3:00'],
              ['4:00'],
              ['5:00'],
              ['6:00'],
              ['7:00']
            ],
            onClick: function(ev, data) {
              // data is a list of datetimes
              var d = data[0].split(' ')[0];
              var t = data[0].split(' ')[1];
              $('#selected-date').html(d);
              $('#selected-time').html(t);
            },
            onClickNavigator: function(ev, instance) {
              var arr = [
                [
                  ['4:00', '5:00', '6:00', '7:00', '8:00'],
                  ['1:00', '5:00'],
                  ['2:00', '5:00'],
                  ['3:30'],
                  ['2:00', '5:00'],
                  ['2:00', '5:00'],
                  ['2:00', '5:00']
                ]
              ]
              instance.setAvailability(arr[0]);
            }
          });
        })(jQuery);
    </script>
                    <?
                }
                else{
                    print("<p class='welcome alert alert-danger'>User does not exist</p>");
                }
             
            }
            else{
                print("<p class='alert alert-warning'>Either this member of staff does not exist of has not setup a schedule. Please contact them to arrange a meeting.</p>"); 
            }
        }
        else{
            print("<p class='alert alert-warning'>Member of Staff not Selected</p>");
        }
    }

    static public function liststaffschedule($STID, $holiday = 0){
        if($STID){
            if($holiday){
                Forms::generatebutton("Add Holiday","schedule.php?edit=-1&away=1","plus","primary","","","Click this button to add a new Holiday");
                Forms::generatebutton("Show Schedule","schedule.php","calendar-alt","primary","","","Click this button to show the time slots in your schedule");
                Forms::generatebutton("Show Meeting Types","meetingtype.php","handshake","primary","","","Click this button to show your meeting types");
               
                $RQ = new ReadQuery("SELECT id, starttime, endtime, startdate, enddate FROM staffschedule WHERE staffid = :stid AND away = 1 AND deleted = 0",
                                array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                ));
                $Rows = array();
                $RowCounter = 0;
                $Cols = array(array("Start","start",1),array("End","end",1),array("","functions",2));
                while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $Schedule =new Schedule($row['id']);
                    $startdate = new DateTime($row['startdate']);
                    $enddate = new DateTime($row['enddate']);
                    $Row1 = array($row['starttime']." ".$startdate->format('d/m/Y'));
                    $Row2 = array($row['endtime']." ".$enddate->format('d/m/Y'));
                    $Row3 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit Holiday'></i></a>","button");
                    $Row4 = array("<a href='?remove=". $row["id"] ."'><i class='fas fa-trash-alt' title='Delete Holiday'></i></a>","button");
                    $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4);
                    $RowCounter++;
                }
                print("<p class='welcome'>List of holidays for ". $_SESSION["username"]."</p>");
                Display::generatedynamiclistdisplay("staffholidaytable",$Cols,$Rows,"Start Date",0);

            }
            else{
                Forms::generatebutton("Add Schedule","schedule.php?edit=-1&active=1","plus","primary","","","Click this button to add a new Slot in your Schedule");
                Forms::generatebutton("Show Holidays","schedule.php?away=1","plane","primary","","","Click this button to show your holidays");
                Forms::generatebutton("Show Meeting Types","meetingtype.php","handshake","primary","","","Click this button to show your meeting types");
               
                $RQ = new ReadQuery("SELECT id, staffday, starttime, endtime FROM staffschedule WHERE staffid = :stid AND active = 1 AND deleted = 0 ORDER BY staffday",
                    array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                ));
                $Rows = array();
                $RowCounter = 0;
                $Cols = array(array("Day","day",1),array("Start Time","starttime",1),array("End Time","endtime",1),array("","functions",2));
                while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $Row1 = array(Schedule::getstaffday($row['staffday']));
                    $Row2 = array($row['starttime']);
                    $Row3 = array($row['endtime']);
                    $Row4 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-edit' aria-hidden='true' title='Edit Holiday'></i></a>","button");
                    $Row5 = array("<a href='?remove=". $row["id"] ."'><i class='fas fa-trash-alt' title='Delete Holiday'></i></a>","button");
                    $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4,$Row5);
                    $RowCounter++;
                }
                print("<p class='welcome'>List of slots available for ". $_SESSION["username"]."</p>");
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
   
    static public function listdepartmentstaff($DID){
        if($_SESSION["userlevel"] == 1){
            print("<p class='welcome'>The list below shows all Staff within this Department. Click on a Staff member to see their schedule.</p>");
            Forms::generatebutton("Departments","schedule.php","arrow-left","secondary");
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
            Forms::generatebutton("Schedule","schedule.php","arrow-left","secondary");
        }
        else{
            Forms::generatebutton("Holidays","schedule.php?away=1","arrow-left","secondary");
        }
       
       $StaffArray = array(array($_SESSION['userid'],$_SESSION['username']));
       $staff = $_SESSION['userid'];
       if($away > 0){          
            if($SID > 0){
                if($startdate != NULL){
                    if(!is_object($startdate)){
                        $startdate = new DateTime($startdate);
                    }           
                    $startdate = $startdate->format('d/m/Y');                   
                }
                if($enddate != NULL){
                    if(!is_object($enddate)){
                        $enddate = new DateTime($enddate);
                    }
                    $enddate = $enddate->format('d/m/Y');
                }
                $Button = "Edit Holiday";
            }
            else{
                if($startdate != NULL){
                    if(!is_object($startdate)){
                        $startdate = new DateTime($startdate);
                    }
                    $startdate = $startdate->format('d/m/Y');
                   
                }
                if($enddate != NULL){
                    if(!is_object($enddate)){
                        $enddate = new DateTime($enddate);
                    }   
                    $enddate = $enddate->format('d/m/Y');
                }
                $Button = "Add Holiday";
            }
            $AwayField = array("Away: ","Text","away",30,$away);
            $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray);
            $StartField = array("Start Time: ","Time","starttime",10,$starttime,"Select the start time");
            $EndField = array("End Time: ","Time","endtime",10,$endtime,"Select the end time");
            $StartDateField = array("Start Date: ","Date","startdate",10,$startdate,"Select the start date");
            $EndDateField = array("End Date: ","Date","enddate",10,$enddate,"Select the end date");
            $Fields = array($AwayField,$StaffField,$StartField,$EndField,$DayField,$StartDateField,$EndDateField);
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