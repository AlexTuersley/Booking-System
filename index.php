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
if($_GET["signout"]){
    User::signout();
}
elseif($_SESSION["userlevel"] > 0){
    print("<p class='welcome'><span>Welcome ".$_SESSION["username"].".</span> To use the booking system select an option in the menu.</p>");    
}
else{

    print("<p class='welcome'>Welcome. To use the booking system either sign up or sign in.</p>"); 
}



function PDOConnection()
{      
  try{      
    $conn = new PDO("mysql:host=".DBSERVER.";dbname=".DBNAME, DBUSER,DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
  }
  catch(PDOException $e){
    echo "PDO Error: " . $e->getMessage();
  }
        
}
WebPage::pageend();
?>