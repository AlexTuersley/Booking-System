<?php
include("config/config.php");
session_start();
$script[0] = "js/ValidationScript.js";
$script[1] = "js/UserScript.js";
$activate = $_GET["activate"];
$UID = $_GET["edit"];
WebPage::headerandnav("User",$_SESSION["userlevel"],"",$script);
if($_SESSION["userlevel"] > 0){
    if($UID == $_SESSION["userid"] || $_SESSION["userlevel"] > 2 && $UID){
        User::addedit($UID);
    }
    elseif($_SESSION["userlevel"] > 2){
        User::listall();
    }
    else{
        print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
        header("refresh:5;url=http://".BASEPATH."/index.php");        
    }
}

else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:5;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>