<?php
include("config/config.php");
session_start();
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
WebPage::headerandnav("Booking",$Level);
if($Level > 0){
   //show all bookings for user
    if($_GET["edit"]){
        //addedit($_GET["edit"]);
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