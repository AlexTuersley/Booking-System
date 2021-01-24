<?php
include("config/config.php");
session_start();
WebPage::headerandnav("User",$_SESSION["userlevel"],"",$script);
if($_SESSION["userlevel"] > 0){
    print("<iframe src='https://docs.google.com/forms/d/e/1FAIpQLSeEi3LxSUXOSJmAOxQiLqGMGVGsWssDiZzizeyBDa14af4F0A/viewform?embedded=true' width='100%' height='1162' frameborder='0' marginheight='0' marginwidth='0'>Loading…</iframe>");
}
else{
    print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
    header("refresh:5;url=http://".BASEPATH."/index.php");
}
?>