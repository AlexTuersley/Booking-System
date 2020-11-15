<?php
Class WebPage{

    static public function headerandnav($pageTitle,$level,$css ="",$scripts=""){
        print("<!DOCTYPE html>
               <html lang='en'>
               <head>
               <meta charset='utf-8' />
               <title>".$pageTitle."</title>");
               if($css != ""){
                 foreach($css as $style){
                    print("<link rel='stylesheet' href=".$style.">"); 
                 }
               }
               if($scripts != ""){
                foreach($scripts as $script){
                    print("<script type='text/javascript' src='".$script."'></script>"); 
                }
              }
               print("
               <link rel='stylesheet' href='/Booking-System/css/style.css'>
               <link rel='stylesheet' href='/Booking-System/css/bootstrap.min.css'>
               <link rel='stylesheet' href='css/bootstrap-grid.min.css'>
               <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
               <script type='text/javascript' src='js/bootstrap.min.js'></script>
               <script type='text/javascript' src='js/bootstrap.bundle.min.js'></script>
               <script src='https://kit.fontawesome.com/b774cd34b7.js' crossorigin='anonymous'></script>
               </head>
               <nav class='navbar navbar-expand-lg'>
               <div class='container'>");
        switch($level){
            case 1:
                $navList = array(array("index.php","Home","fa-book"),array("bookings.php","Bookings","fa-book"),array("schedule.php","Staff","fa-building"),array("user.php","User","fa-user"),array("index.php?signout=true","Sign out","fa-sign-out-alt"));
                break;
            case 2:
                $navList = array(array("index.php","Home","fa-book"),array("bookings.php","Bookings","fa-book"),array("schedule.php","Schedule","fa-calendar"),array("user.php","User","fa-user"),array("index.php?signout=true","Sign out","fa-sign-out-alt"));
                break;
            case 3:
                $navList = array(array("index.php","Home","fa-book"),array("bookings.php","Bookings","fa-book"),array("schedule.php","Schedule","fa-calendar"),array("department.php","Department","fa-university"),array("user.php","Users","fa-users"),array("user.php","User","fa-user"),array("index.php?signout=true","Sign out","fa-sign-out-alt"));
                break;
            default:
                $navList = array(array("index.php","Home","fa-book"),array("signin.php","Sign In","fa-sign-in-alt"),array("signin.php?signup=true","Sign Up","fa-user-plus"));
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
               <main>");

    }

    static public function pageend(){
        print("</main>
               </body
               </html>");
    }

}
?>