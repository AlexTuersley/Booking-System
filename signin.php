<?php
include("config/config.php");
session_start();

$script[0] = "js/ValidationScript.js";
$script[1] = "js/UserScript.js";

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
elseif($_GET["forgot"]=="true"){
    User::forgotpassword();
}
elseif($_GET["signup"]=="true"){
    User::signup();

}
else{
    User::signin();
}
WebPage::pageend();
?>