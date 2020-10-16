<?php


class Schedule {
    private $staffid;
    private $date;
    private $start_time;
    private $end_time;
    private $active;
    private $away;

    function getstaffid(){
        return $this->staffid;
    }
    function setstaffid($val){
        $this->staffid = $val;
    }
    function getdate(){
        return $this->date;
    }
    function setdate($val){
        $this->date = $val;
    }
    function getstarttime(){
        return $this->start_time;
    }
    function setstarttime($val){
        $this->start_time = $val;
    }
    function getendtime(){
        return $this->end_time;
    }
    function setendtime($val){
        $this->end_time = $val;
    }
    function getactive(){
        return $this->active;
    }
    function setactive($val){
        $this->active = $val;
    }
    function getaway(){
        return $this->away;
    }
    function setaway($val){
        $this->away = $val;
    }

    function __construct(){
        
    }
    //add new schedule item
    public function addNewSchedule(){

    }
    //edit schedule item
    public function editSchedule(){

    }

    //make item a holiday(away)
    public function makeScheduleHoliday(){

    }
    //make item active(show on timetable)
    public function activateScheduleItem(){
        
    }

}


?>