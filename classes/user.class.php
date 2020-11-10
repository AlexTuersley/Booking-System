<?php

class User{

    //Class Variables
    //User Login Details
    private $id;
    private $username;
    private $password;
    private $userlevel;
    private $email;
    private $loginstatus;
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
    function setid($val){
        $this->id = $val;
    }
    function getusername(){
        return $this->username;
    }
    function setusername($val){
        $this->username = $val;
    }
    function getpassword(){
        return $this->password;
    }
    function setpassword($val){
        $this->password = $val;
    }
    function getuserlevel(){
        return $this->userlevel;
    }
    function setuserlevel($val){
        $this->userlevel = $val;
    }
    function getemail(){
        return $this->email;
    }
    function setemail($val){
        $this->email = $val;
    }
    function getlogin(){
        return $this->loginstatus;
    }
    function setlogin($Val){
        $this->loginstatus = $Val;
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
    function setphoto($val){
        $this->photo = $val;
    }
    function getdepartment(){
        return $this->department;
    }
    function setdepartment($val){
        $this->department = $val;
    }
    function getbio(){
        return $this->bio;
    }
    function setbio($val){
        $this->bio = $val;
    }
    function getlocation(){
        return $this->location;
    }
    function setlocation($Val){
        $this->location = $location;
    }
   
    //This function runs when Class is initiated sets all user variables based on the User ID passed through to the Class
    function __construct($ID){
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
            $this->loginstatus = $row["loginstatus"];
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
            (email,username,userpassword,userlevel,loginstatus,deleted)
            VALUES(:email,:username,:userpassword,:userlevel,:loginstatus,0)",
            array(
                PDOConnection::sqlarray(":email", $this->getemail(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":username",$this->getusername(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":userpassword", $this->getpassword(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":userlevel", $this->getuserlevel(), PDO::PARAM_INT),
                PDOConnection::sqlarray(":loginstatus", $this->getlogin(), PDO::PARAM_INT)
        ));
        $this->c_ID = $WQ->getinsertid();
        $WQ = new WriteQuery("INSERT INTO userinformation
            (userid,fullname,phone,photo,department,bio,userlocation)
            VALUES(:userid,:fullname,:phone,:photo,:department,:bio,:userlocation)",
            array(
                PDOConnection::sqlarray(":userid", $this->getid(),PDO::PARAM_INT),
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
        loginstatus = :loginstatus,
        deleted = :deleted
        WHERE id = :id  
        ",
        array(
            PDOConnection::sqlarray(":email", $this->getemail(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":username",$this->getusername(),PDO::PARAM_STR),
            PDOConnection::sqlarray(":userpassword", $this->getpassword(), PDO::PARAM_STR),
            PDOConnection::sqlarray(":userlevel", $this->getuserlevel(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":loginstatus", $this->getlogin(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":deleted", $this->getdeleted(), PDO::PARAM_INT),
            PDOConnection::sqlarray(":id", $this->getid(),PDO::PARAM_INT)
        ));
        $WQ = new WriteQuery("UPDATE userinformation SET
                fullname = :fullname,
                phone = :phone,
                photo = :photo,
                department = :department,
                bio = :bio,
                userlocation = :userlocation,
                WHERE userid = :id  
                ",
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
        $username = $_GET["username"];
        $fullname = $_GET["fullname"];
        $email = $_GET["email"];
        $userpassword = $_GET["password"];
        $level = $_GET["userlevel"];
        $phone = $_GET["phone"];
        $photo = $_GET["photo"];
        $department = $_GET["department"];
        $bio = $_GET["bio"];
        $location = $_GET["location"];
        if(checkuserlevel($_SESSION["userid"]) > 2 || $_SESSION["userid"] == $UID){
            if($UID > 0){ 
                $User = new User($UID);
                $User->setfullname($fullname);
                $User->setusername($username);
                $User->setemail($email);
                $User->setpassword($password);
                $User->setuserlevel($level);
                $User->setphone($phone);
                $User->setphoto($photo);
                $User->setdepartment($department);
                $User->setbio($bio);
                $User->setlocation($location);
                $User->save();
            }
            else{
                $User = new User();
                $User->setfullname($fullname);
                $User->setusername($username);
                $User->setemail($email);
                $User->setpassword($password);
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

    //Data from Sign Up form is passed to this function to use in a Query
    static public function signup(){
        $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Fullname = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Email = htmlspecialchars(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL));
        $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));
        $Department = htmlspecialchars(filter_var($_POST["department"], FILTER_SANITIZE_STRING));
        $Submit = $_POST["submit"];
        if($Submit && str_pos($Email,EMAILCHECK)){
            $User = new User();
            $User->setusername($Username);
            $User->setfullname($Fullname);
            $User->setemail($Email);
            $User->setfullname($Fullname);
            $User->setuserlevel($Level);
            $User->setpassword(md5(SALT.$Password));
            $User->savenew();
        }
        else{
            User::signupform();
        }

    }
    //Sign up form
    static public function signupform(){
        $Departments = array();
        $Departments = Departments::getdepartmentsarray();
        $EmailField = array("Email:","Email","email",30,"Enter Your Email");
        $UsernameField = array("Username: ","Text","username",30,"","Enter Your Username");
        $PasswordField = array("Password: ","Password","password",30,"","Enter Your Password");
        $FullnameField = array("Fullname: ","Text","fullname",30,"Enter Your Fullname");
        $UsercheckboxField = array("Staff:","Checkbox","usercheckbox",0,"Select if you're a member of staff");
        $DepartmentField = array("Department: ","Select","department",30,"Select Your Department","",$Departments);
        $Fields = array($EmailField,$UsernameField,$PasswordField,$FullnameField,$UsercheckboxField,$DepartmentField);
        $Button = "Login";
        Forms::generateform("Sign Up Form",substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),"checksignupform(this)",$Fields,$Button);

        ?>

		<script>
			var checkbox = $("#usercheckbox");
			
			$(function(){
				CheckCheckbox();
			});

			checkbox.click(function(){
				CheckCheckbox();
			})

			function CheckCheckbox(){
				var checked = checkbox.is(':checked');
				if(!checked){
					$('#department').parent().hide();
				}else{
					$('#department').parent().show();
				}
			}
		</script>

		<?
    }
    //Data form
    static public function signin(){
        if($_SESSION["userid"] > 0){return true;}
        $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));    
        $Submit = $_POST["submit"];
        if($Submit || isset($_SESSION["userid"])){
            $UserID = User::checksignin();
            if($UserID > 0){
                $User = new User($UserID);
                $_SESSION["username"] = $User->getusername();
                $_SESSION["password"] = md5(SALT.$Password);
                $_SESSION["userid"] = $UserID;
                $_SESSION["userlevel"] = $User->getuserlevel();
                $_SESSION["loginstatus"] = 1;

            }
            else{
                User::signinform();
            }
        }
        else{
            User::signinform();
        }

    }
    static public function signinform(){
        $UsernameField = array("Username: ","Text","username",30,"","Enter Your Username");
        $PasswordField = array("Password: ","Password","password",30,"","Enter Your Password");
        $Fields = array($UsernameField,$PasswordField);
        $Button = "Login";
        Forms::generateform("Sign In Form",substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),"checksigninform(this)",$Fields,$Button);

    }
    static public function checksignin($UID){
        if($_SESSION["username"] && $_SESSION["password"]){
            $Username = $_SESSION["username"];
            $Password = $_SESSION["password"];
            $UID = $_SESSION["userid"];
            $Submit = true;
        } else {
            $Username = $_POST["username"];
            $Password = $_POST["password"];

            //Add the SALT set in config.ini to the password
            $Password = SALT.$password;
            //encrypt the password
            $Password = md5($Password);
            $RQ = new ReadQuery("SELECT id, password FROM users WHERE username = :username",array(
                PDOConnection::sqlarray(":username",$Username,PDO::PARAM_STR)
            ));
            if($RQ->getnumberofresults() > 0){
                $row = $RQ->getresults()->fetch(PDO::FETCH_ASSOC);
                $VerifyPass = password_verify($Password, $row["password"]);

                    if(!$VerifyPass){
                        return 0;
                    }
                    else{
                        return $row["id"];
                    }
            }
            return 0;
        }
        
    }
    static public function logout($UID){
        $WQ = new WriteQuery("UPDATE users SET loginstatus = 0 WHERE id = :id", array(
            PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
        ));
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
    static public function edituserform($UID,$fullname,$username,$email,$password,$level,$phone,$photo,$department,$bio,$location){
        if($UID > 0){

        }
        else{
            
        }
    }
}
?>