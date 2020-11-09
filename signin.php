<?php
include("config/config.php");
session_start();
WebPage::headerandnav("User",$_SESSION["userlevel"]);

if($_SESSION["userlevel"] > 0){
    print("<p><span>Welcome</span>To use the booking system either sign up or sign in.</p>");
}
elseif($_GET["signup"]){
    User::signup();
}
else{
    User::signin();
}
WebPage::pageend();
?>