<?php
include("config/config.php");
$Level = User::checkuserlevel($_SESSION["userid"]);
WebPage::generateheader("Home",CSS,$Level);
if($Level > 0){
   
   
}
else{
    print("<p><span>Permission Denied</span>You do not have permission to view this page.</p>");
}
WebPage::endpage();
?>