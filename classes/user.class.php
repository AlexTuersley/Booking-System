<?php

class User{
    //User Login Details
    private $id;
    private $username;
    private $password;
    private $email;
    //User Information
    private $name;
    private $bio;
    private $photo;
    private $userlevel;
    
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
    function getphoto(){
        return $this->photo;
    }
    function setphoto($val){
        $this->photo = $val;
    }
    function getuserlevel(){
        return $this->userlevel;
    }
    function setuserlevel($val){
        $this->userlevel = $val;
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
    //create user
    public function addUser(){
        
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
    //edit user information
}
?>


