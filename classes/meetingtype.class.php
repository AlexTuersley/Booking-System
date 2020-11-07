<?php
Class Meeting{

    //Class Variables
    private $id;
    private $name;
    private $staffid;
    private $duration;
    private $deleted;

    //getter and setter functions
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
    function getstaffid(){
        return $this->staffid;
    }
    function setstaffid($Val){
        $this->staffid = $Val;
    }
    function getduration(){
        return $this->duration;
    }
    function setduration($Val){
        $this->duration = $Val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($Val){
        $this->deleted = $Val;
    }

    function __construct($ID){
        if($ID > 0){

            $RQ = new ReadQuery("SELECT * FROM meetings WHERE id = :meetingid", array(
                PDOConnection::sqlarray(":meetingid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->name = $row["meetingname"];
            $this->staffid = $row["staffid"];
            $this->confirmed = $row["duration"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
    }
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO meetings(meetingname,staffid,duration,deleted)
                            VALUES(:meetingname,:staffid,:duration,0)",
                            array(
                                PDOConnection::sqlarray(":meetingname",$this->getname(),PARAM_STR),
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PARAM_INT),
                                PDOConnection::sqlarray(":duration",$this->getduration(),PARAM_INT)
                            ));
    }
    function save(){
        $WQ = new WriteQuery("UPDATE meetings SET
                              meetingname = :meetingname,
                              staffid = :staffid,
                              duration = :duration,
                              deleted = :deleted
                              WHERE id = :id",
                            array(
                                PDOConnection::sqlarray(":meetingname",$this->getname(),PARAM_STR),
                                PDOConnection::sqlarray(":staffid",$this->getstaffid(),PARAM_INT),
                                PDOConnection::sqlarray(":duration",$this->getduration(),PARAM_INT),
                                PDOConnection::sqlarray(":deleted",$this->getdeleted(),PARAM_INT),
                                PDOConnection::sqlarray(":id",$this->getid(),PARAM_INT)
                            ));
    }

    static public function addedit($MID){
        $name = $_GET["meetingname"];
        $staffid = $_GET["staffid"];
        $duration = $_GET["duration"];

        if($MID > 0){
            $MeetingType = new Meeting($MID);
            $MeetingType->setname($name);
            $MeetingType->setstaffid($staffid);
            $MeetingType->setduration($duration);
            $MeetingType->save();
        }
        else{
            $MeetingType = new Meeting();
            $MeetingType->setname($name);
            $MeetingType->setstaffid($staffid);
            $MeetingType->setduration($duration);
            $MeetingType->savenew();

        }
    }
    static public function meetingform($MID,$name,$staffid,$duration){
        if($MID > 0){

        }
        else{
            
        }
        Forms::generateform();
       
    }
}

?>