<?php
include("config/config.php");
session_start();
$script[0] = "js/UserScript.js";
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
WebPage::headerandnav("Home",$Level,"",$script);
if($Level > 0){
    print("<p class='welcome'>You have already signed in. You will be redirected shortly");
    header("Location: refresh:5;http://".BASEPATH."/index.php");
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