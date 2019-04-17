<?php

//Singleton pattern
class Session{

    private static $instance;
    private $user;

    public function __construct()
    {
        session_start();
        if(isset($_SESSION["user"])){
            $this->user=$_SESSION["user"];
        }
    }

    public function login($user){
        $this->user=$user;
        $_SESSION['logiran'] = true;
        $_SESSION["user"] = $user;
    }

    public function getUser(){
        return $this->user;
    }

    public function odjava(){
        unset($_SESSION['logiran']);
    }

    function isLogiran(){
        return isset($_SESSION['logiran']) ? true : false;
    }

    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }



}