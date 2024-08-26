<?php

require_once'config.php';

class User{

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $conn;

    public function __construct($conn,$login='',$email='',$firstname='',$lastname=''){
           
        $this->conn=$conn;
        $this->login=$login;
        $this->email=$email;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
    }
    p 
?>