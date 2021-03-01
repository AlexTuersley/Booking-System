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
    
    //get and set functions
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
        //sets the cost of the password, adds a SALT set in config and encrypts the password with md5 and password hashinf
        $options = [
            'cost' => 12
        ];
        $password = SALT . $this->getpassword();
        $password = password_hash(md5($password), PASSWORD_BCRYPT, $options);
        
        $WQ = new WriteQuery("INSERT INTO users
            (email,username,userpassword,userlevel,activated,deleted)
            VALUES(:email,:username,:userpassword,:userlevel,0,0)",
            array(
                PDOConnection::sqlarray(":email", $this->getemail(), PDO::PARAM_STR),
                PDOConnection::sqlarray(":username",$this->getusername(),PDO::PARAM_STR),
                PDOConnection::sqlarray(":userpassword", $password, PDO::PARAM_STR),
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

    function savepassword()
        {     
            $options = [
                'cost' => 12
            ];

            $password = SALT . $this->getpassword();
            $password = password_hash(md5($password), PASSWORD_BCRYPT, $options);

            $WQ = new WriteQuery("UPDATE users SET userpassword = :userpassword WHERE id = :userid;", array(
                PDOConnection::sqlarray(":userpassword",$password,PDO::PARAM_STR),
                PDOConnection::sqlarray(":userid",$this->getid(),PDO::PARAM_INT)
            ));
        }

    /**
     * Deletes a User based on the ID passed through
     * @param int $UID - the ID of the User to be deleteds
     */
    static public function deleteuser($UID){
        $RQ = new ReadQuery("SELECT * FROM bookings WHERE (studentuserid = :id OR staffuserid = :id) AND deleted = 0",array(
            PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getnumberofresults() > 0){
            print("<p class='welcome alert alert-warning'>The User has been not deleted. The User still has active bookings</p>");
            return false;
        }
        else{
            $WQ = new WriteQuery("UPDATE users SET deleted = 1 WHERE id = :id",array(
                PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
            ));
            print("<p class='alert alert-success'>User has successfully been deleted</p>");
        }
        return true;

        print("<p class='welcome alert alert-success'>The User has been deleted</p>");        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    static public function addedit($UID){
        $username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $fullname = htmlspecialchars(filter_var($_POST["fullname"], FILTER_SANITIZE_STRING));
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $level = filter_var($_POST["userlevel"], FILTER_SANITIZE_NUMBER_INT);
        $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
        $photo = filter_var($_POST["photo"], FILTER_SANITIZE_URL);
        $department = filter_var($_POST["department"], FILTER_SANITIZE_NUMBER_INT);
        $bio = htmlspecialchars(filter_var($_POST["bio"], FILTER_SANITIZE_STRING));
        $location = htmlspecialchars(filter_var($_POST["location"], FILTER_SANITIZE_STRING));
        $Submit = $_POST["submit"];

        $UsernameError = array("usernameerror","Please enter a valid username");
        $FullnameError = array("fullnameerror","Please enter your fullname");
        $EmailError = array("emailerror","Please enter a valid email address");
        $PhoneError = array("phoneerror", "Please enter a valid Phone Number");
        $LevelError = array("levelerror", "Please select a valid User Level from the list");

        if($Submit){
            if($username != "" && $fullname != "" && $email && $level > 0){
                if(User::checkusernameandemail($username,$email,$UID)){
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
                        $User->save();
                        print("<p class='welcome alert alert-success'>".$username." has been edited</p>"); 
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
                        print("<p class='welcome alert alert-success'>".$username." has been added</p>"); 
                    }
                }
                else{
                    print("<p class='welcome alert alert-danger'><strong>Email or Username in Use</strong> The Email or Username is linked to another account please enter another</p>");
                }
            }
            else{
                $Errors = array($UsernameError,$FullnameError,$EmailError,$LevelError,$PhoneError);
                Forms::generateerrors("Please correct the following errors before continuing.",$Errors,true);
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

    /**
     * checks the level of the user
     * @param int $UID - ID of the User
     * @return int The integer level of the User
     */
    static public function checkuserlevel($UID){
        if($UID > 0){
            $RQ = new ReadQuery("SELECT userlevel FROM users WHERE id = :id",
            array(
                PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
            ));
            if($row = $RQ->getresults() > 0){
                return $row["userlevel"];
            }
        }
        return 0;
    }

    /**
     * Static way to get a User's Username
     * @param int $ID - ID of the User
     * @return string  Username if found, if not return User not found message
     */
    static public function getstaticusername($ID){
        $RQ = new ReadQuery("SELECT username FROM users WHERE id = :id",array(
            PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            return $row["username"];
          }
        return "user not found";
    }

    /**
     * Static way to get a User's Email
     * @param int $ID - ID of the User
     * @return string  Email if found, if not return false
     */
    static public function getstaticemail($ID){
        $RQ = new ReadQuery("SELECT email FROM users WHERE id = :id",array(
            PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
        ));
        if($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            return $row["email"];
          }
        return false;
    }

    /**
     * Activate a User by updating the DB
     * @param int $UID - ID of the User
     */
    static public function activateuser($UID){
        $WQ = new WriteQuery("UPDATE users SET activated = 1 WHERE id = :id AND activated != 1",array(
            PDOConnection::sqlarray(":id",$UID,PDO::PARAM_INT)
        ));
        print("<p class='welcome alert alert-success'>The User has been activated</p>");
    }

    /**
     * Checks if a username or email exist alreadt
     * @param string $Username - name of the User
     * @param string $Email - email of the user
     * @param string optional $ID - ID of the User, used when editing a User
     * @return bool true if query has no results, false if it does
     */
    static public function checkusernameandemail($Username, $Email, $ID = 0){
        if($Username != "" && $Email != ""){
            $RQ = new ReadQuery("SELECT * FROM users WHERE (users.username =:username OR users.email = :email) AND deleted = 0 AND id != :id",array(
                PDOConnection::sqlarray(":username",$Username,PDO::PARAM_STR),
                PDOConnection::sqlarray(":email",$Email,PDO::PARAM_STR),
                PDOConnection::sqlarray(":id",$ID,PDO::PARAM_INT)
            ));
            if($row = $RQ->getnumberofresults() > 0){
                return false;
            }
            return true;
        }
        return false;
    }

    //Function creates a password form for too be displayed using the Forms class
    static public function changepasswordform(){
        $CurrentPasswordField = array("Current Password: ","Password","currentpassword",30,"","Enter your Current Password","","","","");
        $NewPasswordField = array("New Password: ","Password","newpassword",30,"","Enter your New Password","","","","Password you will use to login to the System, must be at least 8 characters long");
        $ConfirmPasswordField = array("Repeat New Password: ","Password","confirmpassword",30,"","Enter your New Password again","","","","Enter the Password you want again");
       
       
       $Fields = array($CurrentPasswordField,$NewPasswordField,$ConfirmPasswordField);
       $Button = "Change Password";
       Forms::generateform("changepasswordform","user.php?password=true"," return checkpasswordform(this)",$Fields,$Button);
    }

    //When the password form is used checks the submitted data and either updates a User's password or returns an Error
    static public function changepassword(){
        $CurrentPassword = htmlspecialchars(filter_var($_POST["currentpassword"], FILTER_SANITIZE_STRING));
        $NewPassword = htmlspecialchars(filter_var($_POST["newpassword"], FILTER_SANITIZE_STRING));
        $ConfirmPassword = htmlspecialchars(filter_var($_POST["confirmpassword"], FILTER_SANITIZE_STRING));

        $Submit = $_POST["submit"];

        $PassError = array("currentpassworderror","Your current password doesn't match the system.");
        $NewError = array("newpassworderror","Please enter your new password. Passwords must be at least 10 Characters! Search online for best password practices for help on creating a secure password.");
        $New1Error = array("new1passworderror","Please re-enter your new password.");
        $MatchError = array("passwordmatcherror","Your new passwords do not match.");
        $BadPWError = array("badpwerror","You cannot use this password! Choose a more secure one.");
        $DefaultError = array("defaulterror","Please fill out all the fields.");

        if($Submit){
            if($CurrentPassword && $NewPassword && $ConfirmPassword){
                $User = new User($_SESSION["userid"]);
                if($ConfirmPassword == $NewPassword){
                    if(password_verify(md5(SALT.$CurrentPassword), $User->getpassword())){
                        $User->setpassword($NewPassword);
                        $User->savepassword();
                        print("<p class='welcome alert alert-success'>Your password has been changed. Use the new password next time you login.</p>");
                    }
                    else{
                        print("<p class='welcome'>To change your password complete the form below and click the change password button.</p>");
                        $Errors = array($PassError);
                        Forms::generateerrors("Correct the following errors before you can continue.",$Errors,false);
                        User::changepasswordform();
                    }
                }
                else{
                    print("<p class='welcome'>To change your password complete the form below and click the change password button.</p>");
                    $Errors = array($MatchError);
                    Forms::generateerrors("Correct the following errors before you can continue.",$Errors,false);
                    User::changepasswordform();
                }
            }
            else{
                print("<p class='welcome'>To change your password complete the form below and click the change password button.</p>");
                $Errors = array($DefaultError);
                Forms::generateerrors("Correct the following errors before you can continue.",$Errors,false);
                User::changepasswordform();
            }
        }
        else{
            print("<p class='welcome'>To change your password complete the form below and click the change password button.</p>");
            User::changepasswordform();
        }

    }

    //Uses the Forms class to generate a Forgotten password form
    static public function forgotpasswordform($Email = ""){
        $EmailField = array("Email:","Email","email",30,$Email,"Enter your Email","","","","User Email e.g. john.example.com");
        $Button = "Forgotten Password";
        print("<p class='welcome'>If you have forgotten your password please complete this form and your password will be sent to your email.</p>");
        $Fields = array($EmailField);
        Forms::generateform("forgotpasswordform","signin.php?forgot=true","return checkforgottenpasswordform(this)",$Fields,$Button);
    }

    /**
     * generates a 10 character random password 
     * @return string $password - 10 character random password
     */
    static public function generatepassword()
        {
        	// start with a blank password
 			$password = "";

  			// define possible characters
  			$possible = "123456789bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";

  			// set up a counter
  			$i = 0;
  			$length = 10;

  			// add random characters to $password until $length is reached
 			while ($i < $length) {

    			// pick a random character from the possible ones
   				 $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

                //if character is already in $password do not add it
    			if (!strstr($password, $char)) {
     				$password .= $char;
      				$i++;
 			   }

 			}

  			return $password;

    }

    //Takes submitted data from forgottenpassword form, creates a new password in the DB and emails it to the User
    static public function forgotpassword(){
        $Email = htmlspecialchars(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));

        $EmailError = array("emailerror","Please enter a valid email address");
        $DefaultError = array("emailerror","The Email entered is not registered for the System");

        $Submit = $_POST["submit"];

        if($Submit){
            if($Email){
                $RQ = new ReadQuery("SELECT id,email,userpassword FROM users WHERE email = :email",array(
                    PDOConnection::sqlarray(":email",$Email,PDO::PARAM_STR)
                ));
                if($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
                    $User = new User($row['id']);
                    $NewPassword = User::generatepassword();
                    $User->setpassword($NewPassword);
                    $User->savepassword();
                    if(function_exists("mail")){
                        $headers[] = 'MIME-Version: 1.0';
                        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                        $headers[] = "From: Booking System <noreply@bookingsystem.com>";
                        $email_subject = "Forgotten Password";
                        $email_message = "<html>
                                          <head><title>Forgotten Password</title></head>
                                          <body>
                                          <p>The Forgotten Form has been completed. Your password is: ".$NewPassword."</p>
                                          <p>If you did not request this please login with this password and change it to your preferred password.</p>
                                          </body>
                                          </html>";
                        $sendmail = mail($Email, $email_subject, $email_message, implode("\r\n", $headers));
                        
                        if($sendmail){
                            print("<p class='alert alert-success'>A message has been sent to your email, to activate your account please click the link send with the message</p>");
                        }
                        else{
                            print("<p class='welcome alert alert-warning'>Unable to send to this Email. Please check your email in the form and try again</p>");
                            User::forgotpasswordform($Email);
                        }
                    }
                    else{
                        print("Email has not been enabled for this server. Please contact the administrator ".ADMIN." to activate your account.");
                    }
                }
                else{
                    $Errors = array($DefaultError);
                    Forms::generateerrors("Please correct the following errors before continuing.",$Errors);
                    User::forgotpasswordform($Email);
                }
            }
            else{
                $Errors = array($EmailError);
                Forms::generateerrors("Please correct the following errors before continuing.",$Errors);
                User::forgotpasswordform($Email);
            }
          
        }
        else{
            User::forgotpasswordform($Email);
        }
    }

    /**
     * Creates a Sign Up form using the forms class
     * @param string $Email - New User's Email address
     * @param string $Username - Username of the New User
     * @param string $Password - Password of the New User
     * @param string $Fullname - Full name of the New User
     * @param int optional $Phone - Phone Number of the New User
     * @param string optional $Bio - Information about the New User
     * @param int $Department - The ID of the Department the User is in, 0 for anyone who isn't a Staff Member
     * @param string $location - Where the New User is based - only for staff
     */
    static public function signupform($Email = "", $Username = "", $Password = "", $Fullname = "", $Phone = "", $Bio = "", $Department = 0, $Location = ""){
        $Departments = array();
        $Departments = Departments::getdepartmentsarray();
        $EmailField = array("Email:","Email","email",30,$Email,"Enter your Email","","","","User Email e.g. john.example.com");
        $UsernameField = array("Username: ","Text","username",30,$Username,"Enter your Username","","","","Username used to login to the system e.g. User1");
        $PasswordField = array("Password: ","Password","password",30,$Password,"Enter your Password","","","","Password you will use to login to the System, must be at least 8 characters long");
        $FullnameField = array("Fullname: ","Text","fullname",30,$Fullname,"Enter your Fullname","","","","Fullname of the User e.g. John Smith");
        $PhoneField = array("Phone: ","Text","phone",30,$Phone,"Enter your phone number(optional)","","","","Phone Number of the User");
        $BioField = array("Bio: ","TextArea","bio",4,$Bio,"Enter some information about yourself and your area of study(optional)","","","","Information about the User e.g. Field of Study");
        $UsercheckboxField = array("Staff:","Checkbox","usercheckbox",0,$Check,"Select if you are a member of staff","","","","Tickbox for members of staff");
        $DepartmentField = array("Department: ","Select","department",30,$Department,"Select your Department",$Departments,"","","The Department the User is in at University e.g. Computer Science");
        $LocationField = array("Location: ","Text","location",30,$Location,"Enter your location at University(optional)","","","","Where the User is on the University Campus e.g. Building 1");

        $Fields = array($EmailField,$UsernameField,$PasswordField,$FullnameField,$PhoneField,$BioField,$UsercheckboxField,$DepartmentField,$LocationField);
        $Button = "Sign Up";
        Forms::generateform("Sign Up Form",substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1)," return checksignupform(this)",$Fields,$Button);

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

    //Data from Sign Up form is passed to this function to use in a Query, if details are correct the User is added to the DB 
    //and an Email is sent to their address
    static public function signup(){
        $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Fullname = htmlspecialchars(filter_var($_POST["fullname"], FILTER_SANITIZE_STRING));
        $Email = htmlspecialchars(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL));
        $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));
        $Bio = htmlspecialchars(filter_var($_POST["bio"], FILTER_SANITIZE_STRING));
        $Phone = htmlspecialchars(filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT));
        $Department = htmlspecialchars(filter_var($_POST["department"], FILTER_SANITIZE_NUMBER_INT));
        $Location = htmlspecialchars(filter_var($_POST["location"], FILTER_SANITIZE_STRING));

        $UsernameError = array("usernameerror","Please enter a valid username");
        $FullnameError = array("fullnameerror","Please enter your fullname");
        $EmailError = array("emailerror","Please enter a valid email address");
        $PasswordError = array("passworderror", "Please enter a password longer than 7 characters");
        $DepartmentError = array("departmenterror", "Please select a department from the list");
        

        $Submit = $_POST["submit"];

        //add this back in to check the email of the user 
        //&& str_pos($Email,EMAILCHECK)
        if($Submit){
            if($Username != "" && $Fullname != "" && strlen($Password) > 7 && $Email){
                if(User::checkusernameandemail($Username,$Email)){
                    $User = new User();
                    $User->setusername($Username);
                    $User->setfullname($Fullname);
                    $User->setemail($Email);
                    $User->setpassword($Password);
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

                    
                
                    if(function_exists("mail")){
                        $headers[] = 'MIME-Version: 1.0';
                        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                        $headers[] = "From: Booking System <noreply@bookingsystem.com>";
                        $Link = BASEPATH."/user.php?activate=".$User->getid();

                        $email_subject = "New User Registration";
                        $email_message = "<html>
                                        <head><title>New User Registration</title></head>
                                        <body>
                                        <p>A user has signed up to the booking system with this email ".$Email."</p>
                                        <p>to confirm your registration click this <a href='".$Link."'>link</a></p>
                                        <p>If this was not you, your account may have been hacked, changing your password is recommended.</>
                                        </body>
                                        </html>";
                        $sendmail = mail($Email, $email_subject, $email_message, implode("\r\n", $headers));
                        if($sendmail){
                            print("<p class='welcome alert alert-success'>A message has been sent to your email, to activate your account please click the link send with the message</p>");
                        }
                        else{
                            print("<p class='warning'>Unable to send to this Email. Please check your email in the form and try again</p>");
                            User::signupform($Email,$Username,$Password,$Fullname,$Phone,$Bio,$Department,$Location);
                        }
                    }
                    else{
                        print("<p class='welcome alert alert-danger'><strong>Email or Username in Use</strong> The Email or Username is linked to another account please enter another</p>");
                    }
                }
                else{
                    print("<p class='welcome alert alert-success'>Your Account has been created. Email has not been enabled for this server. Please contact the administrator ".ADMIN." to activate your account.</p>");
                }
               }
            else{
                $Errors = array($UsernameError,$PasswordError,$FullnameError,$EmailError,$DepartmentError);
                Forms::generateerrors("Please correct the following errors before continuing.",$Errors,true);
                User::signupform($Email,$Username,$Password,$Fullname,$Phone,$Bio,$Department,$Location);     
            }
                       
        }
        else{
            User::signupform();
        }

    }

    /**
     * Function generates a HTML About Me Page with User Details
     * @param int $ID - ID of the User
     */
    static public function aboutmepage($ID){
        include("schedule.class.php");
        if($ID > 0){
            $RQ = new ReadQuery("SELECT email,username,userlevel,fullname,phone,department,bio,userlocation 
                                 FROM users JOIN userinformation ON users.id = userinformation.userid
                                 WHERE users.id = :id", array(
                                     PDOConnection::sqlarray(':id',$ID,PDO::PARAM_INT)
                                 ));
            

            $row = $RQ->getresults()->fetch(PDO::FETCH_ASSOC);
            if($row){
                if($row["userlevel"] == 2){
                    $schedule = Schedule::liststaffslots($ID,30);
                }
                else{
                    $schedule = array();
                }
                if($ID === $_SESSION['userid']){
                    Forms::generatebutton("Edit","user.php?edit=".$ID,"user-edit","primary");
                    Forms::generatebutton("Feedback","feedback.php","comment","primary");
                }
                else{
                    //booking button
                }
                $Bio = "";
                $UserInfo = "<p><strong>Full name:</strong> ".$row['fullname']."</p>
                             <p><strong>Email:</strong> ".$row['email']."</p>";
                if($row['phone'] > 0){
                    $UserInfo .= "<p><strong>Phone:</strong> ".$row['phone']."</p>";
                }  
                // if($row['department' > 0]){
                //     $UserInfo += "<p>Department: ".$row['departmentname']."</p>";
                // }   
            
                if($row['userlocation'] != NULL){
                    $UserInfo .= "<p><strong>Location:</strong> ".$row['userlocation']."</p>";
                }

                if($row['bio'] != NULL){
                    $UserInfo .= "<p><strong>Bio:</strong> ".$row['bio']."</p>";
                }
                if($row['photo'] != ""){
                    $UserPic = $row['photo'];
                }
                else{
                    $UserPic = DEFAULTPICTURE;
                }
                print("
                <div class='row' style='margin-top:20px;'>
                <div class='col-6'>
                    <img style='height:256px;width:256px;'src='".$UserPic."' alt='User Profile Picture'>
                </div>
                <div class='col-6'>
                    ".$UserInfo."
                </div>");
                if($schedule[0]){
                    print("
                    <div class='container'>
                        <h3 class='welcome'>Weekly Availability for ".$row['username']." (30 Min Slots)</h3>
                        <div id='picker' style='clear:both;'>
                    </div>");
                    ?>
                    <script type="text/javascript">
                    (function($) {
                        var availabilityArray = <?echo json_encode($schedule[0]);?>;
    
                    $('#picker').markyourcalendar({
                        availability: availabilityArray
                        ,
                        onClick: function(ev, data) {
                        },
                        onClickNavigator: function(ev, instance) {
                            instance.setAvailability(availabilityArray);                    
                        }
                    });
                    })(jQuery);
                    </script>
                    <?
                }
                else{

                }
               
            }
        }
    }
  
    //Users signinform submitted data to either Sign the User in or reject their credentials
    static public function signin(){
        if($_SESSION["userid"] > 0){
            return true;
        }
        $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
        $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));    
        $Submit = $_POST["submit"];
        if($Submit || isset($_SESSION["userid"])){
            $UserID = User::checksignin();
            if($UserID > 0){
                $User = new User($UserID);
                $_SESSION["username"] = $User->getusername();
                $_SESSION["userid"] = $UserID;
                $_SESSION["userlevel"] = $User->getuserlevel();
                $_SESSION['email'] = $User->getemail();
                $_SESSION['location'] = $User->getlocation();
                $_SESSION["loginstatus"] = 1;
                //print("<p class='welcome'>Login Successful. You will be redirected to the main page shortly</p>");
                header("Location: http://".BASEPATH."/index.php");
            }
            else{
                $LoginError = array("defaulterror","Your username or password is incorrect.");
        	    $UsernameError = array("usernameerror","Please enter a username");
                $PasswordError = array("passworderror","Please enter a password");
                if($Username != "" && $Password != ""){
                    $Errors = array($LoginError);
                }
                else if($Username != ""){
                    $Errors = array($PasswordError,$LoginError);
                }
                else if($Password != ""){
                    $Errors = array($UsernameError,$LoginError);
                }
                else{
                    $Errors = array($UsernameError,$PasswordError,$LoginError);
                }
               
                Forms::generateerrors("The following errors must be corrected before you can sign in",$Errors,false);
                User::signinform($Username, $Password);
            }
        }
        else{
            User::signinform($Username, $Password);
        }
        return false;

    }

    /**
     * Uses the Forms Class to generate a HTML Form
     * @param string $Username
     * @param string $Password
     */
    static public function signinform($Username = "", $Password=""){
        $UsernameField = array("Username: ","Text","username",30,$Username,"Enter Your Username","","","","Username e.g. User1");
        $PasswordField = array("Password: ","Password","password",30,$Password,"Enter Your Password","","","","Password used when signing up to the System");
        $Fields = array($UsernameField,$PasswordField);
        $Button = "Login";
        Forms::generateform("signinform",substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1),"return checksigninform(this)",$Fields,$Button);

    }

    /**
     * function checks the username and password passed from the sign in form to verify if
     * @return int User ID
     */
    static public function checksignin(){
        if($_SESSION["username"] && $_SESSION["password"]){
            $Username = $_SESSION["username"];
            $Password = $_SESSION["password"];
            $UID = $_SESSION["userid"];
            $Submit = true;
        } else {
            $Username = htmlspecialchars(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
            $Password = htmlspecialchars(filter_var($_POST["password"], FILTER_SANITIZE_STRING));

            //Add the SALT set in config.ini to the password for verification
            $Password = md5(SALT.$Password);
            $RQ = new ReadQuery("SELECT id, userpassword, activated FROM users WHERE deleted = 0 AND username = :username",array(
                PDOConnection::sqlarray(":username",$Username,PDO::PARAM_STR)
            ));
            if($RQ->getnumberofresults() > 0){
                $row = $RQ->getresults()->fetch(PDO::FETCH_ASSOC);
                $PasswordCheck = password_verify($Password, $row["userpassword"]);
                if(!$PasswordCheck || $row["activated"] === 0){    
                    return 0;
                }
                else{
                    return $row["id"];
                }
            }

        }
        return 0;
    }

    //Signs User out by destroying the session
    static public function signout(){
        session_destroy();
    }
   
    //Creates a HTML Display using the Display class to show all Users 
    static public function listusers(){
        $RQ = new ReadQuery("SELECT id, username, fullname, userlevel,activated FROM users JOIN userinformation on users.id = userinformation.userid WHERE deleted = 0", null);
        $Cols = array(array("Username","username",1),array("Fullname","fullname",1),array("User Level","userlevel",1),array("","functions",3));
        $Rows = array();
        $Rowcounter = 0;
        while($row = $RQ->getresults()->fetch(PDO::FETCH_BOTH)){
            $Row1 = array($row["username"]);
            $Row2 = array($row["fullname"]);
            $Row3 = array(User::getuserleveltype($row["userlevel"]));
            if($row["activated"] > 0){
                $Row4 = array("<i class='fas fa-check-circle' style='color:green;' title='user activated'></i>");
            }
            else{
                $Row4 = array("<a href='?activate=". $row["id"] ."'><i class='fas fa-power-off' aria-hidden='true' style='color:red; cursor: pointer;' title='Activate ".$row["username"]."'></i></a>","button");
       
            }
            $Row5 = array("<a href='?edit=". $row["id"] ."'><i class='fas fa-user-edit' aria-hidden='true' title='Edit ".$row["username"]."'></i></a>","button");
            $Row6 = array("<a href='?remove=".$row["id"]."' title='Delete ".$row["username"]."'  ><i class='fas fa-trash-alt' title='Delete ".$row["username"]."'></i></a>","button");
            $Rows[$Rowcounter] = array($Row1,$Row2,$Row3,$Row4,$Row5,$Row6);
            $Rowcounter++;
        }
       
        Display::generatedynamiclistdisplay("userstable",$Cols,$Rows,"Username",0);
    }
     
    /**
     * Gets the Name of the User Level
     * @param int $userlevel - interger value of the User Level
     * @return string string name of the User Level
     */
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

    //Creates an array of the User Levels with their name and value
    static public function getuserlevelarray(){
        $UserlevelArray[0] = array(1,"Student");
        $UserlevelArray[1] = array(2,"Staff");
        $UserlevelArray[3] = array(3,"Admin");
        return $UserlevelArray;
    }

    /**
     * Creates a Sign Up form using the forms class
     * @param int $UID - ID of the User
     * @param string $email
     * @param string $fullname - Full name of the User
     * @param string $username
     * @param int $level - level of the User
     * @param int optional $phone - Phone Number of the New User
     * @param string NOT IMPLEMENTED optional $photo - string to the file location of the User uploaded photo
     * @param string optional $bio - Information about the New User
     * @param int $department - The ID of the Department the User is in, 0 for anyone who isn't a Staff Member
     * @param string $location - Where the New User is based - only for staff
     */
    static public function edituserform($UID,$fullname,$username,$email,$level,$phone,$photo,$department,$bio,$location){
        
        if(strpos($_SERVER['REQUEST_URI'],'users.php')){
            Forms::generatebutton("Users","users.php","arrow-left","secondary");
            $Path = "users.php?edit=".$UID."";
        }
        else{
            $Path = "user.php?edit=".$UID."";
            if($UID = $_SESSION['userid']){
                Forms::generatebutton("User Details","user.php","arrow-left","secondary");
            }
        }
        $EmailField = array("Email:","Email","email",30,$email,"Enter your Email","","","","User Email e.g. john.example.com");
        $UsernameField = array("Username: ","Text","username",30,$username,"Enter your Username","","","","Username used to login to the system e.g. User1");
        $FullnameField = array("Fullname: ","Text","fullname",30,$fullname,"Enter your Fullname","","","","Fullname of the User e.g. John Smith");
        $PhoneField = array("Phone: ","NumberText","phone",30,$phone,"Enter your phone number(optional)","","","","Phone Number of the User");
        $BioField = array("Bio: ","TextArea","bio",4,$bio,"Enter some information about yourself and your area of study(optional)","","","","Information about the User e.g. Field of Study");
        $LocationField = array("Location: ","Text","location",30,$location,"User location on campus","","","","Where the User is on the University Campus e.g. Building 1");
        $DepartmentArray = Departments::getdepartmentsarray();
        $UserlevelArray = User::getuserlevelarray();
        if($_SESSION["userlevel"] > 2){
            $DepartmentField = array("Department: ","Select","department",30,$department,"Select a Department",$DepartmentArray,"","","The Department the User is in at University e.g. Computer Science");
            $UserlevelField = array("User Level: ","Select","userlevel",30,$level,"Select the User Level",$UserlevelArray,"","","Level access the User has e.g. Student");         
        }
        else{
            $DepartmentField = array("Department: ","Select","department",30,$department,"Department that the user is in",$DepartmentArray,"","readonly","The Department the User is in at University e.g. Computer Science");
            $UserlevelField = array("User Level: ","Select","userlevel",30,$level,"User Level",$UserlevelArray,"","readonly","Level access the User has e.g. Student");            
        }
        if($UID > 0){
            $Button = "Edit User";
        }
        else{
            $Button = "Add User";
        }
        $Fields = array($EmailField,$UsernameField,$FullnameField,$UserlevelField,$DepartmentField,$PhoneField,$BioField,$LocationField);
        Forms::generateform("User Form",$Path," return checkuserform(this)",$Fields,$Button);

        ?>

		<script>	
			$(function(){
                if($("#userlevel option:selected").val() == 2){
                  ShowFields();
                }
                else{
                  HideFields();
                }
			});

			$("#userlevel").change(function(){
                console.log($("#userlevel option:selected").val());
                if($("#userlevel option:selected").val() == 2){
                  ShowFields();
                }
                else{
                  HideFields();
                }
            });

			function ShowFields(){
                $('#department').parent().show();
                $('#location').parent().show();
			}
            function HideFields(){
                $('#department').parent().hide();
                $('#location').parent().hide();
            }
		</script>

		<?

    }
}
?>