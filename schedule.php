<?php
session_start();
include("config/config.php");

$Level = $_SESSION["userlevel"];
$Department = $_GET["department"];
$Staff = $_GET["staff"];
$Script[0] = "js/jquery.tablesorter.min.js";
WebPage::headerandnav("Home",$Level,"",$Script);
if($Level > 0){
    if($Level >= 2){
        //shows staff schedule and lets staff member edit their schedule
    }
    else{
        if($Department){
            Schedule::listdepartmentstaff($Department);
        }
        elseif($Staff){
            //Schedule::liststaffschedule($Staff);
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