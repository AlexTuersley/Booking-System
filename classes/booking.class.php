<?php
class Booking{

    private $studentid;
    private $staffid;
    private $confirmed;
    private $note;
    private $deleted;

    function getstudentid(){
        return $this->studentid;
    }
    function setstudentid($val){
        $this->studentid = $val;
    }
    function getstaffid(){
        return $this->staffid;
    }
    function setstaffid($val){
        $this->staffid = $val;
    }
    function getconfirmed(){
        return $this->confirmed;
    }
    function setconfirmed($val){
        $this->confirmed = $val;
    }
    function getnote(){
        return $this->note;
    }
    function setnote($val){
        $this->note = $val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($val){
        $this->deleted = $val;
    }

    function __construct(){
        
    }
    //add new booking
    public function addNewBooking(){

    }
    //confirm/unconfirm booking booking
    public function confirmBooking(){

    }
    //cancel the Booking
    public function cancelBooking(){

    }
    //add to booking note
    public function addNote(){

    }
    //edit booking note
    public function editNote(){
        
    }
    //upload photo to server and store location in db
    public function uploadPhoto(){

    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    public function addedit(){

    }
}


?>
