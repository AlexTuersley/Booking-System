<?php
include("config/config.php");
session_start();
WebPage::headerandnav("User",$_SESSION["userlevel"]);
if($_SESSION["userlevel"] > 0){
   
   
}
elseif($_GET["activate"]){
    User::activateuser($_GET["activate"]);
}
else{
    print("<p><span>Welcome</span>To use the booking system either sign up or sign in.</p>");
}
WebPage::pageend();
?>