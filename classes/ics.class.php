<?php
class ICS {
    var $data;
    var $name;
    var $filelocation;
    function ICS($start,$end,$name,$description,$location,$summary) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTAMP:".date("Ymd\THis\Z")."\nUID:".$name."\nDTSTART:".$start."\nDTEND:".$end."\nCLASS:PUBLIC\nDESCRIPTION:".$description."\nSUMMARY:".$summary."\nTRANSP:OPAQUE\nEND:VEVENT\nEND:VCALENDAR\n";
        $this->filelocation = dirname(__FILE__).$name."ics";
    }
    function save() {
        // ideally put it in ../Bookings/filename.ics
        file_put_contents($this->name.".ics",$this->data);
    }
    function delete(){
        unlink($this->name.".ics");
    }
    function getICS() {
        return $this->name.".ics";
    }
}
?>