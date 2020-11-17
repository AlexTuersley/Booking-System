<?php
include("config/config.php");
session_start();
$script[0] = "js/ValidationScript.js";
$script[1] = "js/UserScript.js";
$activate = $_GET["activate"];
WebPage::headerandnav("User",$_SESSION["userlevel"],"",$script);
if($_SESSION["userlevel"] > 0){
    if($_GET["password"]){
        User::changepassword();
    }
    else{
        User::addedit($_SESSION["userid"]);  
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