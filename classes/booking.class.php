<?php
class Booking{

    private $studentid;
    private $staffid;
    private $confirmed;
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

    public function unconfirmBooking(){

    }
    //add/edit note
    public function addNote(){

    }
    public function editNote(){
        
    }
}


?>
