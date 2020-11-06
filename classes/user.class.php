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
    //return the User type as a String value
    function getuserleveltype(){
        switch ($this->userlevel) {
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
    //This function runs when Class is iniated sets all user variables based on the User ID passed through to the Class
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

    //Data from Sign Up form is passed to this function to use in a Query
    static public function signup(){

    }
    //Sign up form
    static public function signupform(){

    }
    //Data form
    static public function signin(){

    }
    //Sign in form
    static public function signinform(){

    }
    static public function listusers(){
        $RQ = new ReadQuery("SELECT id, username, fullname FROM users WHERE deleted = 0", null);

    }
    static public function edituserform($UID,$fullname,$username,$email,$password,$level,$phone,$photo,$department,$bio,$location){
        if($UID > 0){

        }
        else{
            
        }
    }
}
?>