<?php
class ICS {
    var $data;
    var $name;
    var $filelocation;
    function ICS($start,$end,$name,$description,$location) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nTZID:Europe/London\nDTSTART:".date("Ymd\THis\Z",strtotime($start))."\nDTEND:".date("Ymd\THis\Z",strtotime($end))."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:".$name."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
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