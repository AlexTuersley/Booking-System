<?php
class ICS {
    //Class Variables
    private $data;
    private $name;
    private $filelocation;

    /**
     * Function Uses the variables passed through to create the data for an ICS file, give it a name and save the location
     * @param string $start - starttime of the event
     * @param string $end - end time of the event
     * @param string $name - name of the file
     * @param string $description - details about the event
     * @param string $location - location of the event
     * @param string $summary - summary of the event
     */
    function ICS($start,$end,$name,$description,$location=NULL,$summary) {
        $this->name = $name;
        $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTAMP:".date("Ymd\THis\Z")."\nUID:".$name."\nDTSTART:".$start."\nDTEND:".$end."\nCLASS:PUBLIC\nDESCRIPTION:".$description."\nSUMMARY:".$summary."\nTRANSP:OPAQUE\nEND:VEVENT\nEND:VCALENDAR\n";
        $this->filelocation = dirname(__FILE__).$name."ics";
    }

    //saves the file onto the server
    function save() {
        // ideally put it in ../Bookings/filename.ics
        file_put_contents($this->name.".ics",$this->data);
    }

    //deleted file from the server
    function delete(){
        unlink($this->name.".ics");
    }

    /**
     * Function returns the file from it with the .ics extension
     * @return string filename - name of the file with extension
     */
    function getICS() {
        return $this->name.".ics";
    }
}
?>