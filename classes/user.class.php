<?php

class User{
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
    private $photo;
    private $department;
    private $bio;
    private $location;
    
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
    function getname(){
        return $this->name;
    }
    function setname($val){
        $this->name = $val;
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
            $this->password = $row["password"];
            $this->userlevel = $row["userlevel"];
            $this->email = $row["email"];
            $this->loginstatus = $row["loginstatus"];
            $this->name = $row["name"];
            $this->photo = $row["photo"];
            $this->department = $row["department"];
            $this->bio = $row["bio"];
            $this->location = $row["location"];  
        }else{
            //Create New
            $this->setdeleted(false);
        }
        
    }
    //Save new User data to DB
    function savenew(){

    }
    //Update current User data on DB
    function save(){

    }

    //delete user
    static public function deleteuser(){
        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    static public function addedit($UID){

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
        $RQ = new ReadQuery("SELECT id FROM users WHERE deleted = 0", null);

    }
    static public function edituserform($UID){

    }
}
?>