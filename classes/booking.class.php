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
            $this->meetingtype = $row["meetingid"];
            $this->confirmed = $row["confirmed"];
            $this->note = $row["note"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
        
    }
    function save(){

    }
    function savenew(){

    }
    //cancel the Booking
    static public function cancelbooking(){

    }
    //add to booking note
    static public function addnote(){

    }
    //edit booking note
    static public function editnote(){
        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    static public function addedit(){

    }
}


?>
