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
    header("Location: http://".BASEPATH."/index.php"); 

}
elseif($_SESSION["userlevel"] > 0){
    print("<p class='welcome'><span>Welcome ".$_SESSION["username"].".</span> To use the booking system select an option in the menu.</p>");
    User::getlatestbooking($_SESSION['userid']);
}
else{

    print("<p class='welcome'>Welcome. To use the booking system either sign up or sign in.</p>"); 
}
print("<div class='container welcome'>
       <h2>Features</h2>
       <h3>Calendar Booking System</h3>
       <img style='width:100%; border-style:solid;' src='http://localhost/Booking-System/Images/Calendar.png'>
       <h3>Edit Bookings</h3>
       <img style='width:100%; border-style:solid;' src='http://localhost/Booking-System/Images/Bookings.png'>
       <h3>Departments</h3>
       <img style='width:100%; border-style:solid;' src='http://localhost/Booking-System/Images/Departments.png'>
       <h3>Customisable User Page</h3>
       <img style='width:100%; border-style:solid;' src='http://localhost/Booking-System/Images/UserProfile.png'>");

print("</div>");
WebPage::pageend();
?>