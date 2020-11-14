<?php
include("config/config.php");
session_start();
$activate = $_GET["activate"];
WebPage::headerandnav("User",$_SESSION["userlevel"]);
if($_SESSION["userlevel"] > 0){
    User::addedit($_SESSION["userid"]);  
}
elseif($activate > 0){
    User::activateuser($_GET["activate"]);
}
else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:10;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>