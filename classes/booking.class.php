<?php
class Booking{

    //Class Variables
    private $id;
    private $studentid;
    private $staffid;
    private $start_time;
    private $end_time;
    private $meetingtype;
    private $recurring;
    private $note;
    private $deleted;

    //get and set functions
    function getid(){
        return $this->id;
    }
    function setid($Val){
        $this->id = $Val;
    }
    function getstudentid(){
        return $this->studentid;
    }
    function setstudentid($Val){
        $this->studentid = $Val;
    }
    function getstaffid(){
        return $this->staffid;
    }
    function setstaffid($Val){
        $this->staffid = $Val;
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
    function getmeetingtype(){
        return $this->meetingtype;
    }
    function setmeetingtype($Val){
        $this->meetingtype = $Val;
    }
    function getrecurring(){
        return $this->recurring;
    }
    function setrecurring($Val){
        $this->recurring = $Val;
    }
    function getnote(){
        return $this->note;
    }
    function setnote($Val){
        $this->note = $Val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($Val){
        $this->deleted = $Val;
    }

    /**
     * When an ID is passed to the Class, date is gathered based on this ID
     * @param int $ID - Booking ID
     */
    function __construct($ID = 0){
        if($ID > 0){
            $RQ = new ReadQuery("SELECT * FROM bookings WHERE id = :bookingid", array(
                PDOConnection::sqlarray(":bookingid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->studentid= $row["studentuserid"];
            $this->staffid = $row["staffuserid"];
            $this->start_time = $row["start_time"];
            $this->end_time = $row["end_time"];
            $this->meetingtype = $row["meetingtype"];
            $this->recurring = $row["recurring"];
            $this->note = $row["notes"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
        
    }

    //Gets booking data using the get function and pushes the data onto the database
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO bookings
        (studentuserid,staffuserid,start_time,end_time,meetingtype,recurring,notes,deleted)
        VALUES(:studentid,:staffid,:starttime,:endtime,:meetingid,:recurring,:note,0)",
        array(
            PDOConnection::sqlarray(":studentid",$this->getstudentid(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":meetingid",$this->getmeetingtype(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":recurring",$this->getrecurring(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":note",$this->getnote(),PDO::PARAM_STR)
        ));

        $this->id = $WQ->getinsertid();
    }

    //Updates a Booking in the database using the get functions
    function save(){
       $WQ = new WriteQuery("UPDATE bookings SET
            studentuserid = :studentid,
            staffuserid = :staffid,
            start_time = :starttime,
            end_time = :endtime,
            meetingtype = :meetingid,
            recurring = :recurring,
            notes = :note
            WHERE id = :id",
                array(
                PDOConnection::sqlarray(":studentid",$this->getstudentid(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":meetingid",$this->getmeetingtype(), PDO::PARAM_INT),
                PDOConnection::sqlarray(":recurring",$this->getrecurring(), PDO::PARAM_INT),
                PDOConnection::sqlarray(":note",$this->getnote(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":id",$this->getid(),PDO::PARAM_INT)
        ));
    }

    /**
     * cancels a booking and sends both users an email to confirm this
     * @param int $BID - the ID of the booking to be deleted
     */
    static public function cancelbooking($BID){
        $Booking = new Booking($BID);
        $WQ = new WriteQuery("UPDATE bookings SET deleted = 1 WHERE id = :id",
            array(PDOConnection::sqlarray(":id",$BID,PDO::PARAM_INT))
        );
        if(function_exists("mail")){
            $BookingTime = $Booking->getstarttime();
            if($_SESSION['userid'] === $Booking->getstaffid()){
                $StaffName = $_SESSION['username'];
                $StudentName = User::getstaticusername($Booking->getstudentid()); 
                $recipients = array($_SESSION['email'], User::getstaticemail($Booking->getstudentid()));
            }
            else{
                $StaffName = User::getstaticusername($Booking->getstaffid());
                $StudentName = $_SESSION['username'];
                $recipients = array($_SESSION['email'], User::getstaticemail($Booking->getstaffid()));
            }
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "From: Booking System <noreply@bookingsystem.com>";
            $NewPassword = $row["password"];
            $email_subject = "Booking Cancellation";
            $email_message = "<html>
                              <head><title>Booking Cancelled</title></head>
                              <body>
                              <p>The Booking at ".$BookingTime." with ".$StaffName." and ".$StudentName." has been cancelled</p>
                              <p>If wish to make another booking please use the system again</p>
                              </body>
                              </html>";
            $sendmail = mail(implode(",",$recipients), $email_subject, $email_message, implode("\r\n", $headers));
            
            if($sendmail){
                print("<p class='welcome alert alert-success'><strong>Booking Deleted</strong> An Email has been sent to your address with details</p>");
            }
            else{
                print("<p class='welcome alert alert-warning'>The Booking has been cancelled. But an email was unable to be sent to your address</p>");
            }
        }
        header("refresh:5,url=".$_SERVER['HTTP_REFERER']);
    }
    /**
     * Confirms the booking will go ahead 
     * @param int $BID - the ID of a Booking
     */
    static public function confirmbooking($BID){
        $WQ = new WriteQuery("UPDATE bookings SET recurring = 1 WHERE id = :id",
            array(PDOConnection::sqlarray(":id",$BID,PDO::PARAM_INT))
        );
    }
    /**
     * Checks the starttime of a Booking for a Staff Member to see if it exists already
     * @param string $starttime - the time of a potential booking
     * @param int $STID - Staff Id
     */
    static public function checkbooking($starttime,$STID){
        $RQ = new ReadQuery("SELECT * FROM bookings WHERE start_time = :starttime AND staffuserid = :staff AND deleted = 0",array(
            PDOConnection::sqlarray(":starttime",$starttime,PDO::PARAM_STR),
            PDOConnection::sqlarray(":staff",$STID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getnumberofresults() > 0){
            return false;
        }
        return true;

    }
    /**
     * User inputted data from a form is passed to this function, which then updates or adds the data to the database
     * @param int $BID - ID of the Booking
     */  
    static public function addedit($BID){
        include('schedule.class.php');
        $studentid = filter_var($_POST["student"], FILTER_SANITIZE_NUMBER_INT);
        $staffid = filter_var($_POST["staff"], FILTER_SANITIZE_NUMBER_INT);
        $starttime = htmlspecialchars(filter_var($_POST["starttime"], FILTER_SANITIZE_STRING));
        $meeting = filter_var($_POST["meeting"], FILTER_SANITIZE_NUMBER_INT);
        $note = htmlspecialchars(filter_var($_POST["note"], FILTER_SANITIZE_STRING));
        $Submit = $_POST['submit'];
    
        if($Submit){
            if($starttime != NULL){
                if(!is_object($starttime)){
                    $starttime = str_replace("/","-",$starttime);
                    $starttime = date("y-m-d H:i:s",strtotime($starttime));
                    $starttime = new DateTime($starttime);
                }           
                $starttime = $starttime->format('y-m-d H:i:s');                   
            }
            if($starttime != NULL){
                $Duration = Schedule::getstaticduration($meeting);
                $Duration = strval($Duration * 60);
                $endtime = strtotime($starttime) + $Duration;
                $endtime = date("y-m-d H:i:s",$endtime);
                $endtime = new DateTime($endtime);
                $endtime = $endtime->format('y-m-d H:i:s');
            }
            if($BID > 0){
                $Booking = new Booking($BID);
                if($starttime != $Booking->getstarttime()->format('y-m-d H:i:s')){
                    $Update = 1;
                }
                $Booking->setstudentid($studentid);
                $Booking->setstaffid($staffid);
                $Booking->setstarttime($starttime);
                $Booking->setendtime($endtime);
                $Booking->setmeetingtype($meeting);
                $Booking->setnote($note);
                $Booking->save();
                if($Update){
                    if(function_exists("mail")){
                        include('user.class.php');
                        include('meetingtype.class.php');
                        include("ics.class.php");
                        require_once("phpmailer.class.php");
                        require_once("smtp.class.php");
                        require_once("phpmaileroauth.class.php");
                        require_once("phpmaileroauthgoogle.class.php");
                        $ID = $Booking->getid();
                        $StudentUser = new User($studentid);
                        $StudentEmail = $StudentUser->getemail();
                        $StudentName = $StudentUser->getusername();
                        $Description = "Booking at ".$starttime->format('H:i:s d/m/Y')." with ". $_SESSION['username'] ." by ".$StudentName."";
                        $email_message = "<html>
                                          <head><title>Booking Change</title></head>
                                          <body>
                                          <p>Booking at time with ".$_SESSION['username']." has changed to ".$starttime->format('H:i:s d/m/Y')."</p>
                                          </body>
                                          </html>";
                        $ics = new ICS($starttime->format('Ymd\THis\Z'),$endtime->format('Ymd\THis\Z'),"Booking".$ID,$Description,$_SESSION['location'],MeetingType::getmeetingnamestatic($meeting));
                        $ics->save();
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->isHTML(true);
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'tls';
                        $mail->Host = "smtp.gmail.com";
                        $mail->Port = 587;
                        $mail->Username = MAILUSERNAME;
                        $mail->Password = MAILPASS;
                        $mail->setFrom("noreply@bookingsystem.com","Booking System");
                        $mail->addAddress($StudentEmail,$StudentName);
                        $mail->addCC($_SESSION['email'],$_SESSION['username']);
                        $mail->Subject = "Booking Change";
                        $mail->Body = $email_message;
                        $mail->AddAttachment($ics->getICS(),$ics->getICS());
                        if($mail->send()){
                            print("<p class='alert alert-success welcome'>An email has been sent to you to show the changes</p>");
                            print("</div>");
                        }
                        $ics->delete();
                    }
                }
                print("<p class='welcome alert alert-success'>The Booking has been edited.</p>");
            }
            else{
                $Booking = new Booking();
                $Booking->setstudentid($studentid);
                $Booking->setstaffid($staffid);
                $Booking->setstarttime($starttime);
                $Booking->setendtime($endtime);
                $Booking->setmeetingtype($meeting);
                $Booking->setnote($note);
                $Booking->setrecurring(0);
                $Booking->savenew();
                print("<p class='welcome alert alert-success'>The Booking has been added. Please wait for confirmation from the member of staff</p>");
            }
        }
        if($BID > 0){
            $Booking = new Booking($BID);
            Booking::bookingsform($BID,$Booking->getstudentid(),$Booking->getstaffid(),$Booking->getstarttime(),$Booking->getmeetingtype(),$Booking->getnote(),$Booking->getrecurring());
        }
        else{
            Booking::bookingsform($BID,$studentid,$staffid,$starttime,$meeting,$note,$recurring);
        }
        
    }
    /**
     * Function that makes a Booking for Students based on their selections and saves it in the database
     * If successful an email is sent to both users with an ICS file and booking details
     * @param int $Staff - ID of the member of staff the booking will be with
     * @param int $Type - The Meeting Type of the Booking, based on User selection
     * @param string $Booking - The time and date of the Booking
     */
    static public function makebooking($Staff,$Type,$Booking){
        include("schedule.class.php");
        $studentid = $_SESSION['userid'];
        $staffid = $Staff;
        $starttime = str_replace("-"," ",$Booking);
        $starttime = str_replace("/","-",$starttime);
        if(Booking::validatetimedate($starttime,"H:i:s d-m-Y")){
            $starttime = new DateTime($starttime);
            $Duration = Schedule::getstaticduration($Type);
            $Duration = strval($Duration * 60);
            $endtime = strtotime($starttime->format("y-m-d H:i:s")) + $Duration;
            $endtime = date("y-m-d H:i:s",$endtime);
            $endtime = new DateTime($endtime);
            $Meeting = $Type;
            if(Booking::checkbooking($starttime->format("Y-m-d H:i:s"),$staffid)){
                $Booking = new Booking();
                $Booking->setstaffid($staffid);
                $Booking->setstudentid($studentid);
                $Booking->setstarttime($starttime->format("Y-m-d H:i:s"));
                $Booking->setendtime($endtime->format("Y-m-d H:i:s"));
                $Booking->setmeetingtype($Type);
                $Booking->setnote("");
                $Booking->setrecurring(0);
                $Booking->savenew();
                
                if(function_exists("mail")){
                    include('user.class.php');
                    include("meetingtype.class.php");
                    include("ics.class.php");
                    require_once("phpmailer.class.php");
                    require_once("smtp.class.php");
                    require_once("phpmaileroauth.class.php");
                    require_once("phpmaileroauthgoogle.class.php");
                    $ID = $Booking->getid();
                    $StaffUser = new User($staffid);
                    $Link = BASEPATH."/bookings.php?id=".$ID."&confirm=1";
                    $StaffEmail = $StaffUser->getemail();
                    $StaffName = $StaffUser->getusername();
                    $Description = "Booking at ".$starttime->format('H:i:s d/m/Y')." with ". $StaffName ." by ".$_SESSION['username']."";
                    $email_message = "
                                    <head><title>Booking Confirmation</title></head>
                                    <body>
                                    <p>Booking at ".$starttime->format('H:i:s d/m/Y')." with ". $StaffName ." by ".$_SESSION['username']."</p>
                                    <p>To confirm the booking click this <a href='".$Link."'>link</a></p>
                                    <p>If this was not you, your account may have been hacked, changing your password is recommended.</p>
                                    </body>
                                    ";
                    $ics = new ICS($starttime->format('Ymd\THis\Z'),$endtime->format('Ymd\THis\Z'),"Booking".$ID,$Description,$StaffUser->getlocation(),MeetingType::getmeetingnamestatic($Type));
                    $ics->save();
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->isHTML(true);
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 587;
                    $mail->Username = MAILUSERNAME;
                    $mail->Password = MAILPASS;
                    $mail->setFrom("noreply@bookingsystem.com","Booking System");
                    $mail->addAddress($StaffEmail,$StaffName);
                    $mail->addCC($_SESSION['email'],"Student");
                    $mail->Subject = "Booking Confirmation";
                    $mail->Body = $email_message;
                    $mail->AddAttachment($ics->getICS(),$ics->getICS());
                    if(!$mail->send()){
                        $mail->ErrorInfo;
                        print("<p class='alert alert-danger welcome'>The Booking has been added. But we are unable to send a confirmation email please contact an administrator.</p>");
                        header("refresh:5,url=".$_SERVER['HTTP_REFERER']);
                    }else{
                        print("<p class='alert alert-success welcome'><strong>Booking Added</strong> An email has been sent to you to confirm this booking. Please respond.</p><div class='welcome'>");
                        Forms::generatebutton("Bookings","bookings.php","book","primary"); 
                        print("</div>");
                    }   
                    $ics->delete();                             
                }
                else{
                    print("<p class='welcome alert alert-success'>Your Booking has been added. Email has not been enabled for this server. Please contact an administrator to confirm your booking.</p><div class='welcome'>");
                    Forms::generatebutton("Bookings","bookings.php","book","primary");
                    print("</div>");
                }
            }
            else{
                print("<p class='welcome alert alert-danger'><strong>Booking Exists</strong> A booking with this time already exists</p>");
                header("refresh:5,url=".$_SERVER['HTTP_REFERER']);
            }
        }
        else{
            print("<p class='welcome alert alert-danger'><strong>Booking Time Invalid</strong> The booking selected is of an invalid format</p>");
            //header("refresh:5,url=".$_SERVER['HTTP_REFERER']);
        }     
    }

    /**
     * Function displays all Bookings based on the User ID passed through
     * @param int $ID - A User ID used too show all the related bookings
     */
    static public function showbookings($ID){
        include('meetingtype.class.php');
        include('user.class.php');
        if($_SESSION['userlevel'] == 2){
            Forms::generatebutton("Add Bookings","bookings.php","plus","primary");
        }
        $RQ = new ReadQuery("SELECT * FROM bookings WHERE deleted = 0 AND (staffuserid = :id OR studentuserid = :id) ORDER BY id",
            array(
                PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
            ));
        $Cols = array(array("Student", "student",1),array("Staff Member","staff",1),array("Recurring","recurring",1),array("Start", "start",1),array("End","end",1),array("Meeting Type","meetingtype",1), array("","functions",2));
        $Rows = array();
        $RowCounter = 0;
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            if($row["recurring"] == 1){
                $status = "<i class='fas fa-sync' style='color:green;' aria-hidden='true' title='booking recurring'></i>";
            }
            else{
                $status = "<i class='fas fa-circle' style='color:red;' aria-hidden='true' title='booking not recurring'></i>";
            }
            $starttime = new DateTime($row['start_time']);
            $endtime = new DateTime($row['end_time']);
            $Row1 = array(User::getstaticusername($row["studentuserid"]));
            $Row2 = array(User::getstaticusername($row["staffuserid"]));
            $Row3 = array($status);
            $Row4 = array($starttime->format("H:i:s d/m/Y"));
            $Row5 = array($endtime->format("H:i:s d/m/Y"));
            $Row6 = array(MeetingType::getmeetingnamestatic($row["meetingtype"]));
            $Row7 = array("<a href='?edit=". $row["id"] ."' alt='Edit Booking'><i class='fas fa-edit' aria-hidden='true' title='Edit Booking' alt='Edit'></i></a>","button");
            $Row8 = array("<a href='?remove=". $row["id"] ."' alt='Delete Booking'><i class='fas fa-trash-alt' title='Delete Booking' alt='Delete'></i></a>","button");
            $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4,$Row5,$Row6,$Row7,$Row8);
            $RowCounter++;
        }
        print("<p class='welcome'>List of Bookings for ".$_SESSION['username']."</p>");
        Display::generatedynamiclistdisplay("userbookings",$Cols,$Rows,"Start");
    }
   
    /**
     * Creates a Booking form using data passed through to it and displays it on a page
     * @param int $BID - ID of a Booking
     * @param int $studentid - ID of a student
     * @param int $staffid - ID of a staff member
     * @param string $starttime - start time of the booking
     * @param int $meeting - ID of the meeting type associated
     * @param string $note - note to go with the booking
     * @param int $recurring - variable for whether the meeting is recurring or not
     */
    static public function bookingsform($BID,$studentid,$staffid,$starttime,$meeting,$note,$recurring){
        Forms::generatebutton("Bookings","bookings.php","arrow-left","secondary");
        include("user.class.php");
        include("meetingtype.class.php");
        if($starttime != NULL){
            if(!is_object($starttime)){
                $starttime = new DateTime($starttime);
            }           
            $starttime = $starttime->format('H:i:s d/m/Y');                   
        }
        if($staffid === $_SESSION['userid']){
            $StaffArray = array(array($_SESSION['userid'],$_SESSION['username']));
            $StudentArray = array(array($studentid,User::getstaticusername($studentid)));
            $MeetingArray = array(array($meeting,MeetingType::getmeetingnamestatic($meeting)));
        }
        else{
            $StudentArray = array(array($_SESSION['userid'],$_SESSION['username']));
            $StaffArray = array(array($staffid,User::getstaticusername($staffid)));
            $MeetingArray = array(array($meeting,MeetingType::getmeetingnamestatic($meeting)));
        }
        $StudentField = array("Student: ","Select","student",30,$studentid,"Staff Member associated with the schedule",$StudentArray,"","readonly");
        $StaffField = array("Staff: ","Select","staff",30,$staffid,"Staff Member associated with the schedule",$StaffArray,"","readonly");
        //need a function to get starttime and dates for a few weeks if they arent already booked
        $StartField = array("Start Time: ","Text","starttime",30,$starttime,"","","","readonly","");
        $MeetingField = array("Meeting Type","Select","meeting",30,$meeting,"The Type of Meeting e.g. Half an Hour Meeting",$MeetingArray,"","readonly");
        $NoteField = array("Note: ","TextArea","note",4,$note,"Enter some information about the Meeting(optional)","","","","Information about the meeting e.g. Reason for the meeting");
        // if(User::checkuserlevel($_SESSION["userid"] >= 2)){
        //     $recurringField = array();
        // }
        $Fields = array($StudentField,$StaffField,$StartField,$MeetingField,$NoteField);
        if($BID > 0){
            $Button = "Edit Booking";
        }
        else{
            $Button = "Add Booking";
        }
        Forms::generateform("bookingform","bookings.php?edit=".$BID, "return checkbookingform(true)", $Fields, $Button);
    }

    /**
     * validates a date time passed to the function against a format
     * @param string $datetime - date time to be tested
     * @param string $format - format to test the date time against, if none are sent a default format is used
     * @return bool true if the date time is valid, false if not
     */
    static public function validatetimedate($datetime, $format = "Y-m-d h:i:s"): bool{
        $dateObj = DateTime::createFromFormat($format, $datetime);
        return $dateObj && $dateObj->format($format) == $datetime;
    }
}
?>