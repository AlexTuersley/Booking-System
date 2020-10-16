<?php

class User{
    //User Login Details
    private $id;
    private $username;
    private $password;
    private $userlevel;
    private $email;
    //User Information
    private $name;
    private $bio;
    private $department;
    private $photo;

    
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
    function getname(){
        return $this->name;
    }
    function setname($val){
        $this->name = $val;
    }
    function getbio(){
        return $this->bio;
    }
    function setbio($val){
        $this->bio = $val;
    }
    function getdepartment(){
        return $this->department;
    }
    function setdepartment($val){
        $this->department = $val;
    }
    function getphoto(){
        return $this->photo;
    }
    function setphoto($val){
        $this->photo = $val;
    }
  
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
    
    function __construct(){
        
    }
    //Save new User data to DB
    function savenew(){

    }
    //Update current User data on DB
    function save(){

    }

    //login user
    public function loginUser(){

    }
    //logout user
    public function logoutUser(){

    }
    //delete user
    public function deleteUser(){
        
    }
    //User inputted data from a from is passed to this function, which then updates or adds the data to the database
    public function addedit(){

    }
    //Sign up form
    public function signUpForm(){

    }
    //Sign in form
    public function signInForm(){

    }
}
?>


