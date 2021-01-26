<?php
date_default_timezone_set('Europe/London');
class Booking{

    //Class Variables
    private $id;
    private $studentid;
    private $staffid;
    private $start_time;
    private $end_time;
    private $meetingtype;
    private $confirmed;
    private $note;
    private $deleted;

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
    function getconfirmed(){
        return $this->confirmed;
    }
    function setconfirmed($Val){
        $this->confirmed = $Val;
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
            $this->confirmed = $row["confirmed"];
            $this->note = $row["notes"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
        
    }
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO bookings
        (studentuserid,staffuserid,start_time,end_time,meetingtype,confirmed,notes,deleted)
        VALUES(:studentid,:staffid,:starttime,:endtime,:meetingid,:confirmed,:note,0)",
        array(
            PDOConnection::sqlarray(":studentid",$this->getstudentid(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":meetingid",$this->getmeetingtype(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":confirmed",$this->getconfirmed(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":note",$this->getnote(),PDO::PARAM_STR)
        ));

        $this->id = $WQ->getinsertid();
    }
    function save(){
       $WQ = new WriteQuery("UPDATE bookings SET
            studentuserid = :studentid,
            staffuserid = :staffid,
            start_time = :starttime,
            end_time = :endtime,
            meetingtype = :meetingid,
            confirmed = :confirmed,
            notes = :note
            WHERE id = :id",
                array(
                PDOConnection::sqlarray(":studentid",$this->getstudentid(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":starttime",$this->getstarttime(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":endtime",$this->getendtime(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":meetingid",$this->getmeetingtype(), PDO::PARAM_INT),
                PDOConnection::sqlarray(":confirmed",$this->getconfirmed(), PDO::PARAM_INT),
                PDOConnection::sqlarray(":note",$this->getnote(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":id",$this->getid(),PDO::PARAM_INT)
        ));
    }

    //cancel the Booking
    static public function cancelbooking($BID){
        $WQ = new WriteQuery("UPDATE bookings SET deleted = 1 WHERE id = :id",
            array(PDOConnection::sqlarray(":id",$BID,PDO::PARAM_INT))
        );
    }
    //used by staff to confirm that the bookign will go ahead
    static public function confirmbooking($BID){
        $WQ = new WriteQuery("UPDATE bookings SET confimed = 1 WHERE id = :id",
            array(PDOConnection::sqlarray(":id",$BID,PDO::PARAM_INT))
        );
    }

    //edit booking note
    static public function editnote($BID,$note){
        $WQ = new WriteQuery("UPDATE bookings SET note = :note WHERE id = :id",
            array(PDOConnection::sqlarray(":note",$note,PDO::PARAM_STR)),
            array(PDOConnection::sqlarray(":id",$BID,PDO::PARAM_INT))
        );
    }
    static public function checkbooking($Starttime){
        $RQ = new ReadQuery("SELECT * FROM bookings WHERE start_time = :starttime AND deleted = 0",
            PDOConnection::sqlarray(":starttime",$Starttime,PDO::PARAM_STR)
        );
        if($row = $RQ->getnumberofresults() > 0){
            return false;
        }
        return true;

    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    static public function addedit($BID){
        $studentid = filter_var($_POST["student"], FILTER_SANITIZE_NUMBER_INT);
        $staffid = filter_var($_POST["staff"], FILTER_SANITIZE_NUMBER_INT);
        $starttime = $_GET["starttime"];
        $endtime = $_GET["endtime"];
        $meeting = filter_var($_POST["meeting"], FILTER_SANITIZE_NUMBER_INT);
        $note = htmlspecialchars(filter_var($_POST["note"], FILTER_SANITIZE_STRING));
        $Submit = $_POST['submit'];

        if($BID > 0){
            $Booking = new Booking($BID);
            $Booking->setstudentid($studentid);
            $Booking->setstaffid($staffid);
            $Booking->setstarttime($starttime);
            $Booking->setendtime($endtime);
            $Booking->setmeetingtype($meeting);
            $Booking->setnote($note);
            $Booking->save();
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
            $Booking->setconfirmed(0);
            $Booking->savenew();
            print("<p class='welcome alert alert-success'>The Booking has been added. Please wait for confirmation from the member of staff</p>");
        }
    }
    static public function showbookings($ID){
        include('meetingtype.class.php');
        include('user.class.php');
        $RQ = new ReadQuery("SELECT * FROM bookings WHERE deleted = 0 AND staffuserid = :id OR studentuserid = :id ORDER BY id",
            array(
                PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
            ));
        $Cols = array(array("Student", "student",1),array("Staff Member","staff",1),array("Status","status",1),array("Start", "start",1),array("End","end",1),array("Meeting Type","meetingtype",1), array("","functions",2));
        $Rows = array();
        $RowCounter = 0;
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            if($row["confirmed"] == 1){
                $status = "<i class='fas fa-check-circle' aria-hidden='true' title='booking confirmed'></i>";
            }
            else{
                $status = "<i class='fas fa-times-circle' aria-hidden='true' title='booking not confirmed'></i>";
            }
            $starttime = new DateTime($row['start_time']);
            $endtime = new DateTime($row['end_time']);
            $Row1 = array(User::getstaticusername($row["studentuserid"]));
            $Row2 = array(User::getstaticusername($row["staffuserid"]));
            $Row3 = array($status);
            $Row4 = array($starttime->format("H:i:s d/m/Y"));
            $Row5 = array($endtime->format("H:i:s d/m/Y"));
            $Row6 = array(MeetingType::getmeetingnamestatic($row["meetingtype"]));
            $Row7 = array("<a href='?edit=". $row["id"] ."' alt='Edit Booking'><i class='fas fa-edit' aria-hidden='true' title='Edit Booking'></i></a>","button");
            $Row8 = array("<a href='?edit=". $row["id"] ."' alt='Delete Booking'><i class='fas fa-trash-alt' title='Delete Booking'></i></a>","button");
            $Rows[$RowCounter] = array($Row1,$Row2,$Row3,$Row4,$Row5,$Row6,$Row7,$Row8);
            $RowCounter++;
        }
        print("<p class='welcome'>List of Bookings for ".$_SESSION['username']."</p>");
        Display::generatedynamiclistdisplay("userbookings",$Cols,$Rows,"Start");
    }
    //for students, staff use addedit to add booking
    static public function makebooking($Staff,$Type,$Booking){
        include("schedule.class.php");
        $studentid = $_SESSION['userid'];
        $staffid = $Staff;
        $starttime = str_replace("-"," ",$Booking);
        $starttime = str_replace("/","-",$starttime);
        //$starttime = date("y-m-d H:i:s",$starttime); 
        $starttime = new DateTime($starttime);
        $Duration = Schedule::getstaticduration($Type);
        $Duration = strval($Duration * 60);
        $endtime = strtotime($starttime->format("y-m-d H:i:s")) + $Duration;
        $endtime = date("y-m-d H:i:s",$endtime);
        $endtime = new DateTime($endtime);
        $Meeting = $Type;

        echo $starttime->format("Y-m-d H:i:s");
        echo $endtime->format("Y-m-d H:i:s");
        echo $_SERVER['HTTP_REFERER'];
        $Booking = new Booking();
        $Booking->setstaffid($staffid);
        $Booking->setstudentid($studentid);
        $Booking->setstarttime($starttime->format("Y-m-d H:i:s"));
        $Booking->setendtime($endtime->format("Y-m-d H:i:s"));
        $Booking->setmeetingtype($Type);
        $Booking->setnote("");
        $Booking->setconfirmed(0);
        $Booking->savenew();
        if(function_exists("mail")){
            include('user.class.php');
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "From: Booking System <noreply@bookingsystem.com>";
            $Link = "bookings.php?id=".$Booking->getid()."&confirm=1";

            $email_subject = "Booking Confirmation";
            $email_message = "<html>
                                <head><title>NBooking Confirmation</title></head>
                                <body>
                                <p>You have made a booking at ".$startttime." with ".User::getstaticusername($staffid)."</p>
                                <p>to confirm the booking click this <a href='".$Link."'>link</a></p>
                                <p>If this was not you, your email may have been hacked, changing your password is recommended.</>
                                </body>
                                </html>";
            $sendmail = mail($Email, $email_subject, $email_message, implode("\r\n", $headers));
            if($sendmail){
                print("<p class='alert alert-success welcome'><strong>Booking Added</strong> An email has been sent to you to confirm this booking. Please respond.</p><div class='welcome'>");
                Forms::generatebutton("Bookings","bookings.php","book","primary"); 
                print("</div>");
            }
            else{
                print("<p class='alert alert-danger welcome'>The Booking has been added. But we are unable to send a confirmation email please contact an administrator.</p>");
                header("refresh:5,url=".$_SERVER['HTTP_REFERER']);
            }
                                
        }
        else{
            print("<p class='welcome alert alert-success'>Your Booking has been added. Email has not been enabled for this server. Please contact an administrator to confirm your booking.</p><div class='welcome'>");
            Forms::generatebutton("Bookings","bookings.php","book","primary");
            print("</div>");
        }
    }
    static public function bookingsform($BID,$studentid,$staffid,$starttime,$endtime,$meeting,$note,$confirmed){

        if($staffid === $_SESSION['userid']){
            $StaffArray = array(array($_SESSION['userid'],$_SESSION['username']));
            //$StudentArray = array(array($studentid,User::getstaticusername($studentid)));
        }
        else{
            $StudentArray = array(array($_SESSION['userid'],$_SESSION['username']));
            //$StaffArray = array(array($staffid,User::getstaticusername($staffid)));
        }
        //$StaffField = array("Student: ","Select","staff",30,$studentid,"Staff Member associated with the schedule",$StudentArray,"","readonly");
        //$StaffField = array("Staff: ","Select","staff",30,$staffid,"Staff Member associated with the schedule",$StaffArray,"","readonly);
        $StartField = array("Start Time: ","Text","start_time",30,$starttime,"","","","readonly","");
        $EndField = array("End Time: ","Text","end_time",30,$endtime,"","","","readonly","");
        $MeetingField = array();
        $NoteField = array("Note: ","TextArea","note",4,$Bio,"Enter some information about the Meeting(optional)","","","","Information about the meeting e.g. Reason for the meeting");
        if(User::checkuserlevel($_SESSION["userid"] >= 2)){
            $ConfirmedField = array();
        }
        if($BID){
            $Button = "Edit Booking";
        }
        else{
            $Button = "Add Booking";
        }
        Forms::generateform("bookingform", "booking.php?edit=".$BID, "return checkbookingform(true)", $Fields, $Button);
    }
}




?>
