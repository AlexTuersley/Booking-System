<?php
session_start();
include("config/config.php");
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
WebPage::headerandnav("Home",$Level);
if($_GET["signout"] && $Level > 0){
    User::signout();
    print("<p class='welcome'>You have been logged out. Redirecting shortly</p>");
    header("refresh:10;url=http://".BASEPATH."/index.php"); 

}
elseif($_SESSION["userlevel"] > 0){
    print("<p class='welcome'><span>Welcome ".$_SESSION["username"].".</span> To use the booking system select an option in the menu.</p>");    
}
else{

    print("<p class='welcome'>Welcome. To use the booking system either sign up or sign in.</p>"); 
}
WebPage::pageend();
?>