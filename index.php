<?php
include("config/config.php");
$Level = User::checkuserlevel($_SESSION["userid"]);
WebPage::headerandnav("Home",$level);
if($Level > 0){
   
   
}
else{
    print("<p><span>Welcome.</span> To use the booking system either sign up or sign in.</p>");
}
WebPage::pageend();
?>