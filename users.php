<?php
include("config/config.php");
session_start();
$script[0] = "js/ValidationScript.js";
$script[1] = "js/UserScript.js";
$activate = $_GET["activate"];
$UID = $_GET["edit"];
$remove = $_GET["remove"];
WebPage::headerandnav("User",$_SESSION["userlevel"],"",$script);
if($_SESSION["userlevel"] > 2){
    if($UID){
        User::addedit($UID);
    }
    elseif($remove){
        User::delete($remove);
        User::listusers();
    }
    elseif($activate){
        User::activateuser($activate);
    }
    else{
        User::listusers();
    }
}

else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:5;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>