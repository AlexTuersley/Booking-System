<?php


class Schedule {

    //Class Variables
    private $id;
    private $staffid;
    private $date;
    private $start_time;
    private $end_time;
    private $active;
    private $away;

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
    function getdate(){
        return $this->date;
    }
    function setdate($Val){
        $this->date = $Val;
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

    function __construct(){
        if($ID > 0){

            $RQ = new ReadQuery("SELECT * FROM staffschedule WHERE id = :staffscheduleid", array(
                PDOConnection::sqlarray(":staffscheduleid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->staffid = $row["staffid"];
            $this->date = $row["day"];
            $this->startime = $row["start_time"];
            $this->end_time = $row["end_time"];
            $this->active = $row["active"];
            $this->away = $row["away"];
        }
        else{
            $this->setdeleted(false);
        }
    }
    function save(){

    }
    function savenew(){

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
    public function addedit(){

    }

}


?>