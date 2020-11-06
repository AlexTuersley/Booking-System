<?php
include("config/config.php");
$Level = User::checkuserlevel($_SESSION["userid"]);
if($Level > 0){
    $navList = array(array("bookings.php","bookings","fa-book"),array("schedule.php","staff","fa-building"),array("user.php","user","fa-user"));
    if($Level > 1){
        $navList = array(array("bookings.php","bookings","fa-book"),array("schedule.php","schedule","fa-calendar"),array("user.php","user","fa-user"));
        if($Level > 2){
            $navList = array(array("bookings.php","bookings","fa-book"),array("schedule","schedule.php","fa-calendar"),array("department.php","department","fa-university"));
        }
    }
}
else{
    print("<p><span>Permission Denied</span>You do not have permission to view this page.</p>");
}
?>