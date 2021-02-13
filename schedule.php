<?php
session_start();
include("config/config.php");

$Level = $_SESSION["userlevel"];
$Department = $_GET["department"];
$Staff = $_GET["staff"];
$Holiday = $_GET['away'];
$MeetingType = $_GET['type'];
$Booking = $_GET['booking'];
$User = $_GET['user'];
$CSS[0] = "/Booking-System/css/jquery-ui.min.css";
$CSS[1] = "/Booking-System/css/calendar.css";
$Script[0] = "js/jquery.tablesorter.min.js";
$Script[1] = "js/jquery-ui.min.js";
$Script[2] = "js/CalendarPicker.js";
$Script[3] = "js/mark-your-calendar.js";
$Script[4] = "js/ValidationScript.js";
$Script[5] = "js/ScheduleScript.js";
WebPage::headerandnav("Schedule",$Level,$CSS,$Script);

if($Level > 0){
    // if($Level > 2){
    //     //showusers with schedule link
    //     //then showusers schedule with holiday link and meeting type
    //     //or addedit
    // }
    if($Level >= 2){
        if($_GET["edit"]){
            Schedule::addedit($_GET["edit"]);
        }
        elseif($_GET["remove"]){
            Schedule::deleteschedule($_GET["remove"]);
            if($Holiday){
                Schedule::liststaffschedule($_SESSION["userid"],$Holiday);
            }
            else{
                Schedule::liststaffschedule($_SESSION["userid"]);
            }
        }
        else{
            if($Holiday){
                Schedule::liststaffschedule($_SESSION["userid"],$Holiday);
            }
            else{
                Schedule::liststaffschedule($_SESSION["userid"]);
            }
           
        }
    }
    else{
        if($Department){         
            if($Staff){
                if($MeetingType){
                    Schedule::liststaffavailability($Staff,$MeetingType,$Department);
                }
                else{
                    MeetingType::showmeetingtypes($Staff,$Department);
                }
            }
            else{
                Schedule::listdepartmentstaff($Department);
            }
        } 
        else{
            Schedule::listdepartments();
        }
    }
   
}
else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:10;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>