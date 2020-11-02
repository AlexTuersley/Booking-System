<?php
class Booking{

    //Class Variables
    private $id;
    private $name;
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
    function getname(){
        return $this->name;
    }
    function setname($Val){
        $this->name = $Val;
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

    function __construct($ID){
        if($ID > 0){
            $RQ = new ReadQuery("SELECT * FROM bookings WHERE id = :bookingid", array(
                PDOConnection::sqlarray(":bookingid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->name = $row["name"];
            $this->staffid = $row["staffid"];
            $this->studentid= $row["studentid"];
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
        (bookingname,studentid,staffid,start_time,end_time,meetingtype,confirmed,notes,deleted)
        VALUES(:bookingname,:staffid,:studentid,:starttime,:endtime,:meetingid,:confirmed,:note,0)",
        array(
            PDOConnection::sqlarray(":bookingname",$this->getname(),PDO::PARAM_STR),
            PDOConnection::sqlarray(":studentid",$this->getstudentid(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":starttime",$this->getstarttime()->getdatabasedatetime(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":endtime",$this->getendtime()->getdatabasedatetime(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":meetingid",$this->getmeetingtype(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":confirmed",$this->getconfirmed(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":note",$this->getnote(),PDO::PARAM_STR)
        ));
    }
    function save(){
       $WQ = new WriteQuery("UPDATE bookings SET
            bookingname = :bookingname
            studentid = :studentid,
            staffid = :staffid,
            start_time = :starttime,
            end_time = :endtime,
            meetingtype = :meetingid,
            confirmed = :confirmed,
            notes = :note
            WHERE id = :id",
                array(
                PDOConnection::sqlarray(":bookingname",$this->getname(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":studentid",$this->getstudentid(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":starttime",$this->getstarttime()->getdatabasedatetime(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":endtime",$this->getendtime()->getdatabasedatetime(), PDO::PARAM_STR),
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
    //add to booking note
    static public function addnote(){

    }
    //edit booking note
    static public function editnote(){
        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    static public function addedit($BID){
        $bookingname = $_GET["bookingname"];
        $studentid = $_GET["student"];
        $staffid = $_GET["staff"];
        $starttime = $_GET["starttime"];
        $endtime = $_GET["endtime"];
        $meeting = $_GET["meeting"];
        $note = $_GET["note"];

        if($BID > 0){
            $Booking = new Booking($BID);
            $Booking->setname($bookingname);
            $Booking->setstudentid($studentid);
            $Booking->setstaffid($staffid);
            $Booking->setstarttime($starttime);
            $Booking->setendtime($endtime);
            $Booking->setmeetingtype($meeting);
            $Booking->setnote($note);
            $Booking->save();
        }
        else{
            $Booking = new Booking();
            $Booking->setname($bookingname);
            $Booking->setstudentid($studentid);
            $Booking->setstaffid($staffid);
            $Booking->setstarttime($starttime);
            $Booking->setendtime($endtime);
            $Booking->setmeetingtype($meeting);
            $Booking->setnote($note);
            $Booking->setconfirmed(0);
            $Booking->savenew();
        }
    }
}


?>
