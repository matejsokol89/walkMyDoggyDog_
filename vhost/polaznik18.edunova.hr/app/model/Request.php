<?php

class Request{

    public static function pathInfo(){
        //echo $_SERVER["REDIRECT_PATH_INFO"], "<br />";
        if(isset($_SERVER["PATH_INFO"])){
            return $_SERVER["PATH_INFO"];
        }elseif(isset($_SERVER["REDIRECT_PATH_INFO"])){
            return $_SERVER["REDIRECT_PATH_INFO"];
        }else{
            return "";
        }

    }

    public static function post($key,$defalut=""){
        return isset($_POST[$key]) ? $_POST[$key] : $defalut;
    }


}