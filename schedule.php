<?php
session_start();
include("config/config.php");
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
if($Level > 0){
   
   
}
else{
    print("<p><span>Welcome</span>To use the booking system either sign up or sign in.</p>");
}
WebPage::pageend();
?>