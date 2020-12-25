<?php
Class WebPage{

    static public function headerandnav($pageTitle,$level,$css ="",$scripts=""){
        print("<!DOCTYPE html>
               <html lang='en'>
               <head>
               <meta charset='utf-8' />
               <title>".$pageTitle."</title>        
               <link rel='stylesheet' href='/Booking-System/css/style.css'>
               <link rel='stylesheet' href='/Booking-System/css/bootstrap.min.css'>
               <link rel='stylesheet' href='css/bootstrap-grid.min.css'>");
               if($css != ""){
                 foreach($css as $style){
                    print("<link rel='stylesheet' href=".$style.">"); 
                 }
               }
        print("<script type='text/javascript' src='js/jquery-3.4.1.min.js'></script>
               <script type='text/javascript' src='js/bootstrap.min.js'></script>
               <script type='text/javascript' src='js/bootstrap.bundle.min.js'></script>
               <script src='https://kit.fontawesome.com/45be65547d.js' crossorigin='anonymous'></script>");
               if($scripts != ""){
                foreach($scripts as $script){
                    print("<script type='text/javascript' src='".$script."'></script>"); 
                }
              }
               print("
               </head>  
               <nav class='navbar navbar-expand-lg'>
               <div class='container'>
               ");
                
        switch($level){
            case 1:
                $navList = array(array("index.php","Home","fa-book-open","Return to homepage"),array("bookings.php","Bookings","fa-book","View your Bookings"),array("schedule.php","Staff","fa-building","View Staff and make Bookings"),array("user.php",$_SESSION['username'],"fa-user","Edit your information"),array("user.php?password=true","Change Password","fas fa-key","Change Password"),array("index.php?signout=true","Sign out","fa-sign-out-alt","Sign Out of te system"));
                break;
            case 2:
                $navList = array(array("index.php","Home","fa-book-open","Return to homepage"),array("bookings.php","Bookings","fa-book","View your Bookings"),array("schedule.php","Schedule","fa-calendar","View and edit Schedule"),array("user.php",$_SESSION['username'],"fa-user","Edit your information"),array("user.php?password=true","Change Password","fas fa-key"),array("index.php?signout=true","Sign out","fa-sign-out-alt","Sign Out of the system"));
                break;
            case 3:
                $navList = array(array("index.php","Home","fa-book-open","Return to homepage"),array("bookings.php","Bookings","fa-book","View your Bookings"),array("schedule.php","Schedule","fa-calendar","View and edit Schedule"),array("department.php","Department","fa-university","Add and Edit Departments"),array("users.php","Users","fa-users","Edit Users within the system"),array("user.php",$_SESSION['username'],"fa-user","Edit your information"),array("user.php?password=true","Change Password","fas fa-key","Change your password to a new one"),array("index.php?signout=true","Sign out","fa-sign-out-alt","Sign Out of the system"));
                break;
            default:
                $navList = array(array("index.php","Home","fa-book-open","Return to homepage"),array("signin.php","Sign In","fa-sign-in-alt","Sign in to the system"),array("signin.php?signup=true","Sign Up","fa-user-plus","Sign Upto the System"),array("signin.php?forgot=true","Forgotten Password","fa-user-lock","Recover a Forgotten Password"));
                break;
        }
        
        foreach ($navList as $Item) {
            if($Item[1] == "home"){
                print("
                <a href='".$Item[0]."' class='navbar-brand text-white'>
                    <i class='fas ".$Item[2]."' aria-hidden='false'></i>
                    <span class='link-text logo-text'>Home</span>
                </a>
                </div>
                <ul class='navbar-nav ml-auto'>
                ");
            }
            else{
        
                print("<li class='nav-item pl-1'>
                <a href='".$Item[0]."' class='nav-link'>
                    <i  class='fas ".$Item[2]."' aria-hidden='false'></i>
                    <span class='link-text'>".$Item[1]."</span>
                </a>
                </li>");
            }
        }
        print("</ul>
               </nav>
               <main>
               <div class='container' style='padding-top:2em;'>");

    }

    static public function pageend(){
        print("</div>
               </main>
               </body
               </html>");
    }

}
?>