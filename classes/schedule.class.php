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

    /**
     * If ID is passed to the Class then information is gathered from the server
     * @param int $ID
     */
    function __construct($ID = 0){
        if($ID > 0){

            $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE id = :staffscheduleid", array(
                PDOConnection::sqlarray(":staffscheduleid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->staffid = $row["staffid"];
            $this->day = $row["staffday"];
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

    /**
     * Puts new data into the database, using the get functions to gather the data
     */
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

    /**
     * Updates a database row using the get functions to get the data and ID of the row
     */
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

    /**
     * User inputted data from a form is passed to this function, which then updates or adds the data to the database
     * @param int $SID - ID of the Schedule Item
     */ 
    public function addedit($SID){
        $away = $_GET['away'];
        $active = $_GET['active'];
        $staffid = filter_var($_POST["staff"], FILTER_SANITIZE_NUMBER_INT);
        $day = filter_var($_POST["day"], FILTER_SANITIZE_NUMBER_INT);
        $starttime = htmlspecialchars(filter_var($_POST["starttime"], FILTER_SANITIZE_STRING));
        $endtime = htmlspecialchars(filter_var($_POST["endtime"], FILTER_SANITIZE_STRING));
        $startdate = htmlspecialchars(filter_var($_POST["startdate"], FILTER_SANITIZE_STRING));
        $enddate = htmlspecialchars(filter_var($_POST["enddate"], FILTER_SANITIZE_STRING));
        $Submit = $_POST["submit"];
    
        if($Submit){      
            if($startdate != NULL){
                if(!is_object($startdate)){
                    $startdate = new DateTime($startdate);
                }
            }
            if($enddate != NULL){
                if(!is_object($enddate)){
                    $enddate = new DateTime($enddate);
                }
            } 
            if($SID > 0){
                $Schedule = new Schedule($SID);               
                if($away > 0){
                    if(Schedule::validatedate($startdate) && Schedule::validatedate($enddate)){
                        if($staffid > 0 && $enddate != "" && $startdate != ""){
                            $startdate = $startdate->format('Y-m-d');
                            $enddate = $enddate->format('Y-m-d');
                            $Schedule->setday(0);
                            $Schedule->setaway(1);
                            $Schedule->setactive(0);
                            $Schedule->setstartdate($startdate);
                            $Schedule->setenddate($enddate);
                            if(Schedule::checkholidayslot($SID,$startdate,$enddate,$staffid)){
                                $Schedule->save();
                                print("<p class='alert alert-success'>Holiday has successfully been edited</p>");
                            }  
                        }   
                        else{
                            $DefaultError = array("dateerror","Make sure End Date is later than Start Date");
                            $StartdateError = array("startdateerror","Invalid Start Date");
                            $EnddateError = array("enddateerror","Invalid End Date");
                            $StaffError = array("stafferror","Invalid Staff Id");
                            $Errors = array($DefaultError,$StartdateError,$EnddateError,$StaffError);
                            Forms::generateerrors("Please correct the following errors before continuing.",$Errors,$Submit);
                        }
                    }    
                    else{
                        print("<p class='welcome alert alert-danger><strong>Start or End Date invalid</strong>Please check that the format user is correct</p>");
                    }       
                }
                else{
                    if(Schedule::validatetime($starttime) && Schedule::validatetime($endtime)){
                        if($day > 0 && $day <= 7 && $staffid > 0 && $endtime != "" && $starttime != ""){
                            $Schedule->setstarttime($starttime);
                            $Schedule->setendtime($endtime);
                            $Schedule->setday($day);
                            $Schedule->setaway(0);
                            $Schedule->setactive(1);
                            if(Schedule::checkstaffdayslot($SID,$day,$starttime,$endtime,$staffid)){
                                $Schedule->save();
                                print("<p class='alert alert-success'>Schedule has successfully been edited</p>");
                            }
                        }
                        else{
                            $DefaultError = array("timeerror","Make sure the End Time is later than the Start Time");
                            $DayError = array("dayerror","Please select a valid Day");
                            $StarttimeError = array("starttimeerror","Invalid Start Time"); 
                            $EndtimeError = array("endtimeerror","Invalid End Time");
                            $StaffError = array("stafferror","Invalid Staff Id");
                            $Errors = array($DefaultError,$DayError,$StarttimeError,$EndtimeError,$StaffError);
                            Forms::generateerrors("Please correct the following errors before continuing.",$Errors,$Submit);
                        }
                    }
                    else{
                        print("<p class='alert alert-danger>Enter valid start and end times to create the schedule</p>");
                    }
                   
                }
               
            }
            else{
                $Schedule = new Schedule();
                $Schedule->setstaffid($staffid);      
              
                if($away > 0){
                    if($staffid > 0 && $enddate != "" && $startdate != ""){
                        $startdate = $startdate->format('Y-m-d');
                        $enddate = $enddate->format('Y-m-d');
                        $Schedule->setday(0);
                        $Schedule->setaway(1);
                        $Schedule->setactive(0);
                        $Schedule->setstartdate($startdate);
                        $Schedule->setenddate($enddate);
                        $Schedule->setdeleted(0);
                        if(Schedule::checkholidayslot(-1,$startdate,$enddate,$staffid)){
                            $Schedule->savenew();
                            print("<p class='alert alert-success'>Holiday has successfully been added</p>");
                        }   
                    }  
                    else{
                        $DefaultError = array("dateerror","Make sure End Date is later than Start Date");
                        $StartdateError = array("startdateerror","Invalid Start Date");
                        $EnddateError = array("enddateerror","Invalid End Date");
                        $StaffError = array("stafferror","Invalid Staff Id");
                        $Errors = array($DefaultError,$StartdateError,$EnddateError,$StaffError);
                        Forms::generateerrors("Please correct the following errors before continuing.",$Errors,$Submit);
                    }
                }
                else{
                    if($day > 0 && $day <= 7 && $staffid > 0 && $endtime != "" && $starttime != ""){
                        $Schedule->setstarttime($starttime);
                        $Schedule->setendtime($endtime);
                        $Schedule->setday($day);
                        $Schedule->setaway(0);
                        $Schedule->setactive(1);
                        if(Schedule::checkstaffdayslot(-1,$day,$starttime,$endtime,$staffid)){
                            $Schedule->setdeleted(0);
                            $Schedule->savenew();
                            print("<p class='alert alert-success'>Schedule has successfully been added</p>");
                        }
                    }
                    else{
                        $DefaultError = array("timeerror","Make sure the End Time is later than the Start Time");
                        $DayError = array("dayerror","Please select a valid Day");
                        $StarttimeError = array("starttimeerror","Invalid Start Time"); 
                        $EndtimeError = array("endtimeerror","Invalid End Time");
                        $StaffError = array("stafferror","Invalid Staff Id");
                        $Errors = array($DefaultError,$DayError,$StarttimeError,$EndtimeError,$StaffError);
                        Forms::generateerrors("Please correct the following errors before continuing.",$Errors,$Submit);
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
            if($away){
                Schedule::scheduleform($SID,$staffid,$day,$starttime,$endtime,$active,1,$startdate,$enddate);    
            }
            else{
                Schedule::scheduleform($SID,$staffid,$day,$starttime,$endtime,1,$away,$startdate,$enddate);
            }
            
        }

    }

    /**
     * sets a schedule item to be deleted
     * @param int $SID - ID of the Schedule Item
     */
    static public function deleteschedule($SID){
        $WQ = new WriteQuery("UPDATE staffschedule SET deleted = 1 WHERE id = :id",
            array(PDOConnection::sqlarray(":id",$SID,PDO::PARAM_INT))
        );
        print("<p class='alert alert-success'>Schedule has successfully been deleted</p>");
    }

    /**
     * Creates two arrays one with all the staff slots for the Staff member and one for the Staff members holidays and returns them
     * @param int $STID - Id of the Staff member
     * @param int $Duration - From a meeting type defines the number of staff slots created
     * @return array $slots - array containing the array of holidays and staff slots
     */
    static public function liststaffslots($STID,$Duration){
        $RQ = new ReadQuery("SELECT staffday, starttime, endtime, active, away, startdate, enddate FROM staffschedule WHERE staffid = :stid AND deleted = 0 AND (startdate > NOW() OR startdate IS NULL) ORDER BY staffday",
                                array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                            ));
        $userslot = array();
        $slots = array();
        $holidays  = array();
        $counter = 1;
        $day = 0;
        $counter2 = 0;
        $userslots[0] = array();
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){          
            if($row["away"] > 0) {
                $holidays[$counter2] = array(strtotime("06:00:00 ".$row["startdate"]),strtotime("17:00:00 ".$row["enddate"]));
                $counter2++;
            }
            else{
                if($day === 0){
                    $day = $row['staffday'];
                }
                if($day === $row['staffday']){
                    $duration = strval($Duration * 60);
                    $timeslot = strtotime($row['starttime']);
                    while($timeslot < strtotime($row['endtime'])){
                        $timeslots[] = date('H:i',$timeslot);
                        //echo "slot: ". date('H:i',$timeslot)."\n";

                        $timeslot = $timeslot + $duration;
                    }
                    $days[] = $row['staffday'];
                    $userslot[$counter] = $timeslots;
                }
                else{
                    unset($timeslots);
                    $timeslots = array();
                    $counter++;
                    $day++;
                    $duration = strval($Duration * 60);
                    $timeslot = strtotime($row['starttime']);
                    while($timeslot < strtotime($row['endtime'])){
                        $timeslots[] = date('H:i',$timeslot);
                        $timeslot = $timeslot + $duration;
                    }
                    $userslot[$counter] = $timeslots;
                    $days[] = $row['staffday'];
                }   
            }
        }
        $slots = array($userslot,$holidays,$days);
        return $slots;
    }

    /**
     * function returns a string of a day from an integer input
     * @param int $day
     * @return string name of the day associated with the integer
     */
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
            case 7:
                return "Sunday";
                break; 
            default:
                return "N/A";
            break;
        }

    }

    /**
     * function to check if a time is valid - uses regex to test the time
     * @param string $time - the time to be tested
     * @return bool - true if valid, false if not
     */
    static public function validatetime($time){
        if(strlen($time) > 5){
            $test = preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/", $time);
            if($test){
                return true;
            }
        }
        else{
            $test = preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $time);
            if($test){
                return true;
            }
        }
        return false;
    }
    /**
     * function to check if the date is valid
     * @param string $date - date to be tested
     * @param string $format - format to test the date time against, if none are sent a default format is used
     * @return bool true if the date time is valid, false if not
     */
    static public function validatedate($date, $format = "m/d/Y"): bool{
        if(is_object($date)){
            $dateObj = DateTime::createFromFormat($format, $date->format($format));
            return $dateObj && $dateObj->format($format) == $date->format($format);
        }
        else{
            $dateObj = DateTime::createFromFormat($format, $date);
            return $dateObj && $dateObj->format($format) == $date;
        }
      
    }

    /**
     * Checks whether a Slot exists already for a Staff member
     * @param int $id - id of the slot
     * @param int $day - integer representation of the day
     * @param string $starttime - string start time for the slot 
     * @param string $endtime - string end time for the slot
     * @param int $userid - Id of the user associated with teh slot
     * @return bool false if a slot exists, false if not
     */
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

    /**
     * Checks whether a Holiday exists already for a Staff member
     * @param int $id - id of the holiday
     * @param string $startdate - string start date for the Holiday
     * @param string $endtime - string end time for the Holiday
     * @param int $userid - Id of the user associated with the Holiday
     * @return bool false if a slot exists, false if not
     */
    static public function checkholidayslot($id,$startdate,$enddate,$userid){
        $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE deleted = 0 AND id != :id AND staffid = :staff AND (startdate BETWEEN :startdate AND :enddate OR enddate BETWEEN :startdate AND :enddate)",array(
            PDOConnection::sqlarray(':id',$id,PDO::PARAM_INT),
            PDOConnection::sqlarray(':staff',$userid,PDO::PARAM_INT),
            PDOConnection::sqlarray(':startdate',$startdate,PDO::PARAM_STR),
            PDOConnection::sqlarray(':enddate',$enddate,PDO::PARAM_STR)
        ));
        if($RQ->getnumberofresults() > 0){
            print("<p class='alert alert-warning'><strong>Holiday Exists </strong>A holiday for your User exists between these dates. Please edit or delete the holiday before adding a new one.</p>");
            return false;
        }
        return true;
    }

    /**
     * Gets the Full name of a Staff Member based on the ID given
     * @param int $ID - Id of the Staff member
     * @return string Full name of the user, or false if no name is found
     */
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

    /**
     * Get the duration of a Meeting Type based on an ID passed through
     * @param int $ID - Id of the Meeting Type
     * @return int duration of the Meeting or false if it doesn't exist
     */
    static public function getstaticduration($ID){
        if($ID > 0){
            $RQ = new ReadQuery("SELECT duration FROM meetingtype WHERE id = :id",
            array(
                PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
            ));
            while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
               return $row['duration'];
            }
        }
        return 0;
    }

    /**
     * Get an array of start and end times of bookings in timestamp format
     * @param int $SID - Id of the Staff Member
     * @return array $bookingsArray - array of bookings in timestamp format
     */
    static public function staffbookingstimestamp($SID){
        $currentTime = date('Y-m-d H:i:s');
        $RQ = new ReadQuery("SELECT * FROM bookings WHERE deleted = 0 AND staffuserid = :id AND start_time > :currenttime ORDER BY id",
            array(
                PDOConnection::sqlarray(":id",$SID,PDO::PARAM_INT),
                PDOConnection::sqlarray(":currenttime",$currentTime,PDO::PARAM_INT)
            ));
        $i = 0;
        $bookingsArray = array();
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            $bookingsArray[$i] = array(strtotime($row["start_time"]." GMT"),strtotime($row["end_time"])." GMT");
            $i++;
        }
        return $bookingsArray;
    }

    /**
     * Uses the Calendar Plugin to create an interactive Booking Calendar to make a Booking with a Staff Member
     * @param int $SID - Id of the Staff Member
     * @param int $Type - Meeting Type of the Booking
     * @param int $DID - Id of the Department associated with the Booking
     */
    static public function liststaffavailability($SID,$Type,$DID){
        Forms::generatebutton("Meetings","schedule.php?department=".$DID."&staff=".$SID,"arrow-left","secondary");
        if($SID && $Type){
            $Duration = Schedule::getstaticduration($Type);
            if($Duration > 0){
                $schedule = Schedule::liststaffslots($SID,$Duration);
                $bookings = Schedule::staffbookingstimestamp($SID);
                if($schedule){
                    $name = Schedule::getstaffname($SID);
                    if($name){
                        print("<p class='welcome'>Availability for ".$name."</p>
                        <div id='picker'></div>");
                        print("<p>Selected Time: <span id='selected-time'></span></p>
                               <p>Selected Date: <span id='selected-date'></span></p>
                               <div id='tickbox'>
                               <label for='recurring'>Recurring</label>
                               <input type='checkbox' id='recurring' name='recurring' value=0>
                               </div>");
                        Forms::generatebutton("Make Booking","bookings.php?edit=-1&staff=".$SID."&type=".$Type."&booking=","book","primary","","","","","book-button");
                        ?>
                        <script type="text/javascript">
                        (function($) {
                            var availabilityArray = <?echo json_encode($schedule[0]);?>;
                            var bookingsArray = <?echo json_encode($bookings);?>;
                            var holidaysArray = <?echo json_encode($schedule[1]);?>;
                            var daysArray = <?echo json_encode($schedule[2]);?>;
                            var slotsArray = [[],[],[],[],[],[],[]];
                            for(i = 0; i < Object.keys(availabilityArray).length; i++){
                                 slotsArray[daysArray[i]] = availabilityArray[i+1];
                            }
                            $('#book-button').attr("disabled", true);
                            $('#tickbox').hide();
                            $('#book-button').click(function (e) {
                                e.preventDefault();
                                if ($(this).attr('disabled'))

                                    return false; // Do something else in here if required
                                else
                                    window.location.href = $(this).attr('href');
                            });
                            $('#picker').markyourcalendar({
                                availability: slotsArray,
                                bookings: bookingsArray,
                                holidays: holidaysArray,
                                onClick: function(ev, data) {
                                // data is a list of datetimes
                                var d = data[0].split(' ')[0];
                                var t = data[0].split(' ')[1];
                                $('#selected-date').html(d);
                                $('#selected-time').html(t);
                                
                                var href = $("#book-button").attr("href");
                                var point = href.substring(0, href.lastIndexOf('booking='));
                                point += "booking="+t+":00-"+ d;
                                href = point;
                                $('#book-button').attr("disabled", false);
                                $("#book-button").attr("href", href);
                                if($('#selected-date').html() != "" && $('#selected-time').html()!= ""){
                                    $('#tickbox').show();
                                }
                                else{
                                    $('#tickbox').hide();
                                }
                                    
                                },
                                onClickNavigator: function(ev, instance) {
                                    instance.setAvailability(slotsArray);
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
                print("<p class='alert alert-warning'>This Meeting type does not exist. Please go back and select a valid meeting type.</p>"); 
            }
        }
        else{
            print("<p class='alert alert-warning'>Member of Staff not Selected</p>");
        }
    }

    /**
     * Lists the Slots or Holidays a Staff Member currently has with the ability to add, edit and delete them
     * @param int $STID - Id of the Staff member
     * @param int $holiday - defines whether holidays of slots are displayed
     */
    static public function liststaffschedule($STID, $holiday = 0){
        if($STID){
            if($holiday){
                Forms::generatebutton("Add Holiday","schedule.php?edit=-1&away=1","plus","primary","","","Click this button to add a new Holiday");
                Forms::generatebutton("Show Schedule","schedule.php","calendar-alt","primary","","","Click this button to show the time slots in your schedule");
                Forms::generatebutton("Show Meeting Types","meetingtype.php","handshake","primary","","","Click this button to show your meeting types");
               
                $RQ = new ReadQuery("SELECT id, starttime, endtime, startdate, enddate FROM staffschedule WHERE staffid = :stid AND away = 1 AND deleted = 0 AND (startdate > NOW() OR startdate IS NULL)",
                                array(PDOConnection::sqlarray(":stid",$STID,PDO::PARAM_INT)
                ));
                $Rows = array();
                $RowCounter = 0;
                $Cols = array(array("Start","start",1),array("End","end",1),array("","functions",2));
                while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $Schedule =new Schedule($row['id']);
                    $startdate = new DateTime($row['startdate']);
                    $enddate = new DateTime($row['enddate']);
                    $Row1 = array($startdate->format('d/m/Y'));
                    $Row2 = array($enddate->format('d/m/Y'));
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

    
    /**
     * Creates a table of Staff members within a department with clickable links
     * @param int $DID - Id of the department
     */
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
                $Row1 = array("<a href=?department=".$DID."&staff=".$row["id"].">".$row["fullname"]."</a>","button");
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

    /**
     * Creates a table of Departments with clickable links
     */
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

     /**
     * Creates a Booking form using data passed through to it and displays it on a page
     * @param int $SID - ID of a Schedule or Holiday
     * @param int $staff - ID of a Staff member
     * @param string $starttime - start time of the slot
     * @param string $endtime - end time of the slot
     * @param int $active - is 1 if the Item is a Slot
     * @param int $away - is 1 if Item is a holiday
     * @param string $startdate - start date of the holiday
     * @param string $enddate - end date of the holiday
     */
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
                    $startdate = $startdate->format('m/d/Y');                   
                }
                if($enddate != NULL){
                    if(!is_object($enddate)){
                        $enddate = new DateTime($enddate);
                    }
                    $enddate = $enddate->format('m/d/Y');
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
            $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray);
            // $StartField = array("Start Time: ","Time","starttime",10,$starttime,"","","","","Select the Start Time","",'8:00','16:50',300);
            // $EndField = array("End Time: ","Time","endtime",10,$endtime,"","","","","Select the End Time","",'9:10','17:00',300);
            $StartDateField = array("Start Date: ","Date","startdate",10,$startdate,"","","","","Select the Start Date");
            $EndDateField = array("End Date: ","Date","enddate",10,$enddate,"","","","","Select the End Date");
            $Fields = array($StaffField,$StartField,$EndField,$DayField,$StartDateField,$EndDateField);
            $Path = "schedule.php?edit=".$SID."&away=1";
            $Script = "return checkholidayform(this)";
        }
        else{
            $DayArray = array(array(1,"Monday"),array(2,"Tuesday"),array(3,"Wednesday"),array(4,"Thursday"),array(5,"Friday"));
            $StaffField = array("Staff: ","Select","staff",30,$staff,"Staff Member associated with the schedule",$StaffArray,"","readonly");
            $DayField = array("Day:","Select","day",30,$day,"Select the day you want to add this schedule",$DayArray,"","","Select a day to add this schedule to e.g. Monday");
            $StartField = array("Start Time: ","Time","starttime",10,$starttime,"","","","","Select the Start Time","",'08:00','16:50',300);
            $EndField = array("End Time: ","Time","endtime",10,$endtime,"","","","","Select the End Time","",'09:10','17:00',300);
            $Fields = array($StaffField,$DayField,$StartField,$EndField);
            if($SID > 0){
                $Button = "Edit Schedule";
            }
            else{
                $Button = "Add Schedule";
            }
            $Path = "schedule.php?edit=".$SID."&active=1";
            $Script = "return checkscheduleform(this)";
        }
      
        Forms::generateform("Schedule",$Path,$Script,$Fields,$Button);
    }

}


?>