<?php
session_start();
include("config/config.php");
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
if($Level > 2){
    $UID = $_GET['uid'];
}
$Script[0] = "js/MeetingScript.js";
$Script[1] = "js/jquery.tablesorter.min.js";
$Script[2] = "js/ValidationScript.js";
WebPage::headerandnav("Home",$Level,"",$Script);
if($_GET["signout"] && $Level > 0){
    User::signout();
    header("Location: http://".BASEPATH."/index.php"); 

}
elseif($_SESSION["userlevel"] > 0){

    if($_SESSION["userlevel"] > 2){
        if($UID){
            if($_GET["edit"]){
                MeetingType::addedit($_GET['edit']);
            }
            elseif($_GET["remove"]){
                MeetingType::delete($_GET["remove"]);
                MeetingType::listmeetingtypes($UID);
            }
            else{
                MeetingType::listmeetingtypes($UID);
            }
        }
        else{
            header("url=http://".BASEPATH."/schedule.php");
        }
    }
    else{
        if($_GET["edit"]){
            MeetingType::addedit($_GET['edit']);
        }
        elseif($_GET["remove"]){
            MeetingType::delete($_GET["remove"]);
            MeetingType::listmeetingtypes($_SESSION['userid']);
        }
        else{
            MeetingType::listmeetingtypes($_SESSION['userid']);
        }
    }
   

      
}
else{
    print("<p class='welcome'You do not have permission to access this page. Redirecting shortly.</p>"); 
    header("refresh:5;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>