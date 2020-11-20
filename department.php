<?php
session_start();
include("config/config.php");
if($_SESSION["userlevel"]){
    $Level = $_SESSION["userlevel"];
}
else{
    $Level = 0;
}
$Script[0] = "js/bootbox.min.js";
$Script[1] = "js/deletedialogs.js";
$Script[2] = "js/DepartmentScript.js";
WebPage::headerandnav("Home",$Level,"",$Script);
if($_GET["signout"] && $Level > 0){
    User::signout();
    header("Location: http://".BASEPATH."/index.php"); 

}
elseif($_SESSION["userlevel"] > 0){

    if($_SESSION["userlevel"] >= 3){
        if($_GET["edit"]){
            Departments::addedit($_GET["edit"]);
        }
        elseif($_GET["remove"]){
            Departments::delete($_GET["remove"]);
            Departments::listdepartmentsadmin();
        }
        else{
            Departments::listdepartmentsadmin();
        }

    }
    else{
        print("<p class='welcome'>You do not have permission to access this page. Redirecting shortly</p>");
        header("refresh:5;url=http://".BASEPATH."/index.php");
    }
      
}
else{
    print("<p class='welcome'You do not have permission to access this page. Redirecting shortly.</p>"); 
    header("refresh:5;url=http://".BASEPATH."/index.php");
}
WebPage::pageend();
?>