<?php
include("config/config.php");
session_start();
$Script[0] = "js/BookingScript.js";
$Script[1] = "js/ValidationScript.js";
$Script[2] = "js/jquery.tablesorter.min.js";
$Booking = $_GET['booking'];
$Staff = $_GET['staff'];
$Type = $_GET['type'];
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
WebPage::headerandnav("Booking",$Level,"",$Script);
if($Level > 0){
    if($_GET["edit"]){
        if($Staff && $Booking && $Type){
            Booking::makebooking($Staff,$Type,$Booking);
        }
        Booking::addedit($_GET["bid"]);
    }
    else{
        Booking::showbookings($_SESSION["userid"]);
    }
}
else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:10;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>