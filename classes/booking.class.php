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
    static public function addnewbooking(){

    }
    //confirm/unconfirm booking booking
    static public function confirmbooking(){

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
