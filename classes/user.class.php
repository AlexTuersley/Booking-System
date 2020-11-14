<?php

class User{

    //Class Variables
    //User Login Details
    private $id;
    private $username;
    private $password;
    private $userlevel;
    private $email;
    private $activated;
    private $deleted;
    //User Information
    private $name;
    private $phone;
    private $photo;
    private $department;
    private $bio;
    private $location;
    
    //getter and setter functions
    function getid(){
        return $this->id;
    }
    function setid($Val){
        $this->id = $Val;
    }
    function getusername(){
        return $this->username;
    }
    function setusername($Val){
        $this->username = $Val;
    }
    function getpassword(){
        return $this->password;
    }
    function setpassword($Val){
        $this->password = $Val;
    }
    function getuserlevel(){
        return $this->userlevel;
    }
    function setuserlevel($Val){
        $this->userlevel = $Val;
    }
    function getemail(){
        return $this->email;
    }
    function setemail($Val){
        $this->email = $Val;
    }
    function getlogin(){
        return $this->activated;
    }
    function setlogin($Val){
        $this->activated = $Val;
    }
    function getdeleted(){
        return $this->deleted;
    }
    function setdeleted($Val){
        $this->deleted = $Val;
    }
    function getfullname(){
        return $this->name;
    }
    function setfullname($Val){
        $this->name = $Val;
    }
    function getphone(){
        return $this->phone;
    }
    function setphone($Val){
        $this->phone = $Val;
    }
    function getphoto(){
        return $this->photo;
    }
    function setphoto($Val){
        $this->photo = $Val;
    }
    function getdepartment(){
        return $this->department;
    }
    function setdepartment($Val){
        $this->department = $Val;
    }
    function getbio(){
        return $this->bio;
    }
    function setbio($Val){
        $this->bio = $Val;
    }
    function getlocation(){
        return $this->location;
    }
    function setlocation($Val){
        $this->location = $Val;
    }
   
    //This function runs when Class is initiated sets all user variables based on the User ID passed through to the Class
    function __construct($ID = 0){
        if($ID > 0){
            
            $RQ = new ReadQuery("SELECT * FROM users 
                                 JOIN userinformation on users.id = userinformation.userid
                                 WHERE users.id = :userid", array(
                PDOConnection::sqlarray(":userid",$ID,PDO::PARAM_INT)
            ));
            $row = $RQ->getresults()->fetch(PDO::FETCH_BOTH);
            $this->id = $ID;
            $this->username = $row["username"];
            $this->password = $row["userpassword"];
            $this->userlevel = $row["userlevel"];
            $this->email = $row["email"];
            $this->activated = $row["activated"];
            $this->name = $row["fullname"];
            $this->phone = $row["phone"];
            $this->photo = $row["photo"];
            $this->department = $row["department"];
            $this->bio = $row["bio"];
            $this->location = $row["userlocation"]; 
            $this->deleted = $row["deleted"];
        }else{
            //Create New
            $this->setdeleted(false);
        }
        
    }
    //Save new User data to DB
    function savenew(){
        $WQ = new WriteQuery("INSERT INTO users
            (email,username,userpassword,userlevel,activated,deleted)
            VALUES(:email,:username,:userpassword,:userlevel,0,0)",
            array(
                PDOConnection::sqlarray(":email", $this->getemail(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":username",$this->getusername(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":userpassword", $this->getpassword(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":userlevel", $this->getuserlevel(), PDO::PARAM_INT)
        ));
        $this->id = $WQ->getinsertid();
        $WQ2 = new WriteQuery("INSERT INTO userinformation
            (userid,fullname,phone,photo,department,bio,userlocation)
            VALUES(:userid,:fullname,:phone,:photo,:department,:bio,:userlocation)",
            array(
                PDOConnection::sqlarray(":userid", $this->id,PDO::PARAM_INT),
                PDOConnection::sqlarray(":fullname",$this->getfullname(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":phone",$this->getphone(),PDO::PARAM_INT),
                PDOConnection::sqlarray(":photo", $this->getphoto(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":department", $this->getdepartment(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":bio", $this->getbio(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":userlocation", $this->getlocation(),PDO::PARAM_STR)
        ));
    }
    //Update current User data on DB
    function save(){
        $WQ = new WriteQuery("UPDATE users SET
        email = :email,
        username = :username,
        userpassword = :userpassword,
        userlevel = :userlevel,
        deleted = :deleted
        WHERE id = :id",
        array(
            PDOConnection::sqlarray(":email", $this->getemail(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":username",$this->getusername(),PDO::PARAM_STR),
            PDOConnection::sqlarray(":userpassword", $this->getpassword(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":userlevel", $this->getuserlevel(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":deleted", $this->getdeleted(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":id", $this->getid(),PDO::PARAM_INT)
        ));
        $WQ2 = new WriteQuery("UPDATE userinformation SET
                fullname = :fullname,
                phone = :phone,
                photo = :photo,
                department = :department,
                bio = :bio,
                userlocation = :userlocation
                WHERE userid = :id",
        array(
            PDOConnection::sqlarray(":fullname",$this->getfullname(),PDO::PARAM_STR),
            PDOConnection::sqlarray(":phone",$this->getphone(),PDO::PARAM_INT),
            PDOConnection::sqlarray(":photo", $this->getphoto(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":department", $this->getdepartment(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":bio", $this->getbio(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":userlocation", $this->getlocation(),PDO::PARAM_STR),
            PDOConnection::sqlarray(":id", $this->getid(),PDO::PARAM_INT)
        ));
    }

    //delete user
    static public function deleteuser(){
        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    static public function addedit($UID){
        $username = $_POST["username"];
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $level = $_POST["userlevel"];
        $phone = $_POST["phone"];
        $photo = $_POST["photo"];
        $department = $_POST["department"];
        $bio = $_POST["bio"];
        $location = $_POST["location"];
        $Submit = $_POST["submit"];
        echo $bio;
        if($Submit){
                if($UID > 0){ 
                    $User = new User($UID);
                    $User->setfullname($fullname);
                    $User->setusername($username);
                    $User->setemail($email);
                    $User->setuserlevel($level);
                    $User->setphone($phone);
                    $User->setphoto($photo);
                    $User->setdepartment($department);
                    $User->setbio($bio);
                    $User->setlocation($location);
                    echo $User->getbio();
                    $User->save();
                }
                else{
                    $User = new User();
                    $User->setfullname($fullname);
                    $User->setusername($username);
                    $User->setemail($email);
                    $User->setuserlevel($level);
                    $User->setphone($phone);
                    $User->setphoto($photo);
                    $User->setdepartment($department);
                    $User->setbio($bio);
                    $User->setlocation($location);
                    $User->setlogin(0);
                    $User->setdeleted(0);
                    $User->savenew();
                }
        }

        if($UID > 0){
            $User = new User($UID);
            User::edituserform($UID,$User->getfullname(),$User->getusername(),$User->getemail(),$User->getuserlevel(),$User->getphone(),$User->getphoto(),$User->getdepartment(),$User->getbio(),$User->getlocation());
        }
        else{
            User::edituserform($UID,$fullname,$username,$email,$level,$phone,$photo,$department,$bio,$location);
        }
        
    }

    //When passed an id returns a username
    static public function staticgetusername($UID){
        $RQ = new ReadQuery("SELECT username, fullname FROM users WHERE id = :id",
                array(
                    PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
                ));
        if($row = $RQ->getresults() > 0){
            $username = $row["username"]."(".$row["fullname"].")";
        }
        else{
            $username = NULL;
        }
        return $username;
    }
    //checks the level of the user id passed through
    static public function checkuserlevel($UID){
        if($UID > 0){
            $RQ = new ReadQuery("SELECT userlevel FROM users WHERE :id",
            array(
                PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
            ));
            if($row = $RQ->getresults() > 0){
                return $row["userlevel"];
            }
        }
        return 0;
    }
    static public function activateuser($UID){
        $WQ = new WriteQuery("UPDATE users SET activated = 1 WHERE id = :id AND activated != 1",array(
            PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
        ));
        if($row = $WQ->getresults() > 0){
            return true;
        }
        print("<p>User already activated</p>");
        return false;
    }
    static public function checkusernameandemail($Username, $Email){
        $RQ = new ReadQuery("SELECT * FROM users WHERE users.username =:username OR users.email = :email",array(
            PDOConnection::sqlarray(":username",$Username,PDO::PARAM_STR),
            PDOConnection::sqlarray(":email",$Email,PDO::PARAM_STR)
        ));
        if($row = $RQ->getnumberofresults() > 0){
            return false;
        }
        return true;
    }


    //Data from Sign Up form is passed to this function to use in a Query
    static public function signup(){
        $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Fullname = htmlspecialchars(filter_var($_POST["fullname"], FILTER_SANITIZE_STRING));
        $Email = htmlspecialchars(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL));
        $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));
        $Bio = htmlspecialchars(filter_var($_POST["bio"], FILTER_SANITIZE_STRING));
        $Phone = htmlspecialchars(filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT));
        $Department = htmlspecialchars(filter_var($_POST["department"], FILTER_SANITIZE_STRING));
        $Location = htmlspecialchars(filter_var($_POST["location"], FILTER_SANITIZE_STRING));

        $Submit = $_POST["submit"];
        //add this back in to check the email of the user 
        //&& str_pos($Email,EMAILCHECK)
        if($Submit){
            if(User::checkusernameandemail($Username,$Email)){
                $User = new User();
                $User->setusername($Username);
                $User->setfullname($Fullname);
                $User->setemail($Email);
                $User->setpassword(md5(SALT.$Password));
                if($Department > 0){
                    $User->setuserlevel(2);
                    $User->setdepartment($Department);
                    $Check = 1;
                }
                else{
                    $User->setuserlevel(1);
                    $User->setdepartment(0);
                    $Check = 0;
                }
                $User->setphone($Phone);
                $User->setbio($Bio);
                $User->setlocation($Location);
                $User->savenew();
              
                /*if(function_exists("mail")){
                    $Link = "user.php?activate=".$User->getid();
                    $headers = "From: noreply@bookingsystem.com\n";
                    $email_subject = "New User Registration";
                    $email_message = "Content-type: text/html\n
                                      A user has signed up to the booking system with this email".$Email." to confirm your registration click this link".$Link.".\n
                                      If this was not you, your emai may have been hacked, changing your password is recommended.";
                    $sendmail = mail($Email, $email_subject, $email_message, $headers);
                    if($sendmail){
                        print("<p>A message has been sent to your email, to activate your account please click the link send with the message</p>");
                    }
                    else{
                        print("<p class='warning'>Unable to send to this Email. Please check your email in the form and try again</p>");
                        User::signupform($Email,$Username,$_POST["password"],$Fullname,$Phone,$Bio,$Check,$Department,$Location);
                    }
                }
                else{
                    print("Email has not been enabled for this server. Please conaact the administrator ".ADMIN." to activate your account.");
                }*/
                print("Email has not been enabled for this server. Please conaact the administrator ".ADMIN." to activate your account.");
             
            }
            else{
                User::signupform();     
            }
                       
        }
        else{
            User::signupform();
        }

    }
    //Sign up form
    static public function signupform($Email = "",$Username = "",$Password = "", $Fullname = "",$Phone = "", $Bio = "", $Check = 0,$Department = 0, $Location = ""){
        $Departments = array();
        $Departments = Departments::getdepartmentsarray();
        $EmailField = array("Email:","Email","email",30,$Email,"Enter your Email");
        $UsernameField = array("Username: ","Text","username",30,$Username,"Enter your Username");
        $PasswordField = array("Password: ","Password","password",30,$Password,"Enter your Password");
        $FullnameField = array("Fullname: ","Text","fullname",30,$Fullname,"Enter your Fullname");
        $PhoneField = array("Phone: ","Text","phone",30,$Phone,"Enter your phone number(optional)");
        $BioField = array("Bio: ","TextArea","bio",4,$Bio,"Enter some information about yourself and your area of study(optional)");
        $UsercheckboxField = array("Staff:","Checkbox","usercheckbox",0,$Check,"Select if you are a member of staff","");
        $DepartmentField = array("Department: ","Select","department",30,$Department,"Select your Department",$Departments);
        $LocationField = array("Location: ","Text","location",30,$Location,"Enter your location at University(optional)");

        $Fields = array($EmailField,$UsernameField,$PasswordField,$FullnameField,$PhoneField,$BioField,$UsercheckboxField,$DepartmentField,$LocationField);
        $Button = "Sign Up";
        Forms::generateform("Sign Up Form",substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),"checksignupform(this)",$Fields,$Button);

        ?>

		<script>
			let checkbox = $("#usercheckbox");
			
			$(function(){
				StaffCheckbox();
			});

			checkbox.click(function(){
				StaffCheckbox();
			});

			function StaffCheckbox(){
				let checked = checkbox.is(':checked');
				if(!checked){
					$('#department').parent().hide();
                    $('#location').parent().hide();
				}else{
					$('#department').parent().show();
                    $('#location').parent().show();
				}
			}
		</script>

		<?
    }
    //Data form
    static public function signin(){
        if($_SESSION["userid"] > 0){
            return true;
        }
        $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));    
        $Submit = $_POST["submit"];
        if($Submit || isset($_SESSION["userid"])){
            $UserID = User::checksignin();
            echo $UserID;
            if($UserID > 0){
                $User = new User($UserID);
                $_SESSION["username"] = $User->getusername();
                $_SESSION["password"] = md5(SALT.$Password);
                $_SESSION["userid"] = $UserID;
                $_SESSION["userlevel"] = $User->getuserlevel();
                $_SESSION["loginstatus"] = 1;
                print("<p class='welcome'>Login Successful. You will be redirected to the main page shortly</p>");
                header("refresh:10;url=http://".BASEPATH."/index.php");
            }
            else{
                User::signinform($Username, $Password);
            }
        }
        else{
            User::signinform($Username, $Password);
        }
        return false;

    }
    static public function signinform($Username = "", $Password=""){
        $UsernameField = array("Username: ","Text","username",30,$Username,"Enter Your Username");
        $PasswordField = array("Password: ","Password","password",30,$Password,"Enter Your Password");
        $Fields = array($UsernameField,$PasswordField);
        $Button = "Login";
        Forms::generateform("Sign In Form",substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),"checksigninform(this)",$Fields,$Button);

    }
    static public function checksignin($UID = 0){
        if($_SESSION["username"] && $_SESSION["password"]){
            $Username = $_SESSION["username"];
            $Password = $_SESSION["password"];
            $UID = $_SESSION["userid"];
            $Submit = true;
        } else {
            $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
            $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));

            //Add the SALT set in config.ini to the password and encrypt the password

            $Password = md5(SALT.$Password);
            $RQ = new ReadQuery("SELECT id, userpassword, activated FROM users WHERE username = :username",array(
                PDOConnection::sqlarray(":username",$Username,PDO::PARAM_STR)
            ));
            if($RQ->getnumberofresults() > 0){
                $row = $RQ->getresults()->fetch(PDO::FETCH_ASSOC);
                if($row["password"] == $Password || $row["activated"] == 0){
                    
                    return 0;
                }
                else{
                    return $row["id"];
                }
            }

        }
        return 0;
    }
    static public function logout($UID){
        session_destroy();
    }
   
    static public function listusers(){
        $RQ = new ReadQuery("SELECT id, username, fullname, userlevel FROM users JOIN userinformation on users.id = userinformation.userid WHERE deleted = 0", null);
        $Cols = array(array("Username","username",1),array("Fullname","fullname",1),array("User Level","userlevel",1),array("","",2));
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            $Row1 = array($row["username"]);
            $Row2 = array($row["fullname"]);
            $Row3 = array(User::getuserleveltype($row["userlevel"]));
            $Row4 = array("<a href='?edit&uid=". $row["id"] ."'><i class='fas fa-user-edit' aria-hidden='true' title='Edit ".$row["username"]."'></i></a>","button");
            $Row5 = array("<a alt='Delete ".$row["username"]."' onclick='deletedropdowndialog('" . $row["username"] . "','" . $row["id"] . "');'><i class='fas fa-trash-alt' title='Delete ".$row["username"]."'></i></a>","button");
        }
        $Rows = array($Row1,$Row2,$Row3,$Row4,$Row5);
        Display::generatedynamiclistdisplay("userstable",$Cols,$Rows,"Username",0);
    }
     //return the User type as a String value
     static public function getuserleveltype($userlevel){
        switch ($userlevel) {
            case 1:
                return "Student";
                break;
            case 2:
                return "Staff";
                break;
            case 3:
                return "Admin";
                break;
            default:
                return "Not Registered";
                break;
        }
    }
    static public function getuserlevelarray(){
        $UserlevelArray[0] = array(1,"Student");
        $UserlevelArray[1] = array(2,"Staff");
        $UserlevelArray[3] = array(3,"Admin");
        return $UserlevelArray;
    }
    static public function edituserform($UID,$fullname,$username,$email,$level,$phone,$photo,$department,$bio,$location){
        $EmailField = array("Email:","Email","email",30,$email,"Enter your Email");
        $UsernameField = array("Username: ","Text","username",30,$username,"Enter your Username");
        $FullnameField = array("Fullname: ","Text","fullname",30,$fullname,"Enter your Fullname");
        $PhoneField = array("Phone: ","NumberText","phone",30,$phone,"Enter your phone number(optional)");
        $BioField = array("Bio: ","TextArea","bio",4,$bio,"Enter some information about yourself and your area of study(optional)");
        $DepartmentArray = Departments::getdepartmentsarray();
        $UserlevelArray = User::getuserlevelarray();
        if($_SESSION["userlevel"] > 2){
           
            $DepartmentField = array("Department: ","Select","department",30,$department,"Select a Department",$DepartmentArray);
            $UserlevelField = array("User Level: ","Select","userlevel",30,$level,"Select the User Level",$UserlevelArray);
        }
        else{
            if($level == 2){
                $DepartmentField = array("Department: ","Select","department",30,$department,"The User's Department",$DepartmentArray,"","readonly");
            }
            $UserlevelField = array("User Level: ","Select","userlevel",30,$level,"User Level",$UserlevelArray,"","readonly");
            
        }
        if($UID > 0){
            $Button = "Edit User";
        }
        else{
            $Button = "Add User";
        }
        $Fields = array($EmailField,$UsernameField,$FullnameField,$UserlevelField,$DepartmentField,$PhoneField,$BioField,$LocationField);
        Forms::generateform("User Form","user.php?edit=".$UID,"checkuserform(this)",$Fields,$Button);

    }
}
?>