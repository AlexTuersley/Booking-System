<?php
session_start();
include("config/config.php");
//$Level = User::checkuserlevel($_SESSION["userid"]);
WebPage::headerandnav("Home",$_SESSION["userlevel"]);
if($_GET["signout"] || $_SESSION["logged-in"] > 0){
    User::signout();
}
elseif($_SESSION["userlevel"] > 0){
    print("<p><span>Welcome.</span> To use the booking system either sign up or sign in.</p>"); 
}
else{
    print("<p><span>Welcome ".$_SESSION["username"].".</span> To use the booking system either sign up or sign in.</p>");
}
WebPage::pageend();
?>