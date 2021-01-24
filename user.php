<?php
include("config/config.php");
session_start();
$CSS[0] = "/Booking-System/css/jquery-ui.min.css";
$CSS[1] = "/Booking-System/css/calendar.css";
$script[0] = "js/ValidationScript.js";
$script[1] = "js/UserScript.js";
$script[2] = "js/staffAvailabilityCalendar.js";
$activate = $_GET["activate"];
WebPage::headerandnav("User",$_SESSION["userlevel"],$CSS,$script);
if($_SESSION["userlevel"] > 0){
    if($_GET["password"]){
        User::changepassword();
    }
    elseif($_GET['edit']){
        User::addedit($_SESSION["userid"]);  
    }
    else{
        User::aboutmepage($_SESSION["userid"]);
    }

}
elseif($activate > 0){
    User::activateuser($_GET["activate"]);
}
else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:5;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>