<?php
session_start();
include("config/config.php");

$Level = $_SESSION["userlevel"];
$Department = $_GET["department"];
$Staff = $_GET["staff"];
$Holiday = $_GET['away'];
$CSS[0] = "/Booking-System/css/jquery-ui.min.css";
$CSS[1] = "/Booking-System/css/calendar.css";
$Script[0] = "js/jquery.tablesorter.min.js";
$Script[1] = "js/jquery-ui.min.js";
$Script[2] = "js/CalendarPicker.js";
$Script[3] = "js/mark-your-calendar.js";
WebPage::headerandnav("Home",$Level,$CSS,$Script);

if($Level > 0){
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
        //shows staff schedule and lets staff member edit their schedule
        //Schedule::jsonstaffschedule($_SESSION["userid"]);
    }
    else{
        if($Department){
            Schedule::listdepartmentstaff($Department);
        }
        elseif($Staff){
            Schedule::liststaffavailability($Staff);
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