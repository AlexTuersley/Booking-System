<?php
include("config/config.php");
session_start();
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
WebPage::headerandnav("Home",$Level);
if($Level > 0){
    print("<p><span>Welcome</span>To use the booking system either sign up or sign in.</p>");
}
elseif($_GET["signup"]=="true"){
    print("<div class='container' style='padding-top:2em;'>");
    User::signup();
    print("</div");
}
else{
    print("<div class='container' style='padding-top:2em;'>");
    User::signin();
    print("</div");
}
WebPage::pageend();
?>