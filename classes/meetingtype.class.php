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
            $this->name = $row["name"];
            $this->staffid = $row["staffid"];
            $this->confirmed = $row["duration"];
            $this->deleted = $row["deleted"];
        }
        else{
            $this->setdeleted(false);
        }
    }
}

?>