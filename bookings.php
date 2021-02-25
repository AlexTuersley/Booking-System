<?php
include("config/config.php");
session_start();
$CSS[0] = "/Booking-System/css/jquery-ui.min.css";
$Script[0] = "js/BookingScript.js";
$Script[1] = "js/ValidationScript.js";
$Script[2] = "js/jquery.tablesorter.min.js";
$Script[3] = "js/jquery-ui.min.js";
$Booking = $_GET['booking'];
$Staff = $_GET['staff'];
$Type = $_GET['type'];
$UID = $_GET['uid'];

if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
WebPage::headerandnav("Booking",$Level,$CSS,$Script);
if($Level > 0){ 
    if($_GET['id'] && $_GET['confirm']){
        Booking::confirmbooking($_GET['id']);
    }
     if($Level > 2){
        if($UID){
            if($_GET['edit']){
                Booking::addedit($_GET['edit']);
            }
            elseif($_GET['remove']){
                Booking::cancelbooking($_GET['remove']);
            }
            else{
                Booking::showbookings($UID);
            }
        }    
        else{
            Booking::listbookingusers();
        }
    }
    else{
        Booking::clearbookings($_SESSION['userid']);
        if($_GET["edit"]){
            if($Staff && $Booking && $Type){
                Booking::makebooking($Staff,$Type,$Booking);
            }
            else{
                Booking::addedit($_GET["edit"]);
            }
           
        }
        elseif($_GET['remove']){
            Booking::cancelbooking($_GET['remove']);
        }
        else{
            Booking::showbookings($_SESSION["userid"]);
        }
    }
}
else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:10;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>