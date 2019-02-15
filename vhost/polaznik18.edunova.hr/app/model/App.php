<?php
final class App{

    static function start()
    {
       $pathInfo = Request::pathInfo();
       //echo $pathInfo,"<br />";
       $pathInfo = trim($pathInfo,"/");
       //echo $pathInfo, "<br />";

       $pathParts = explode("/",$pathInfo);
       //print_r($pathParts);

       if(!isset($pathParts[0]) || empty($pathParts[0])){
           $controller = "Index";
       }else{
           if($pathParts[0]==="kontakt"){
            $controller = "Kontakt";
           }elseif($pathParts[0]==="onama"){
            $controller = "Onama"; 
           }else{
            $controller=ucfirst(strtolower($pathParts[0]));
           }
           
       }

       $controller .= "Controller";

       //echo $controller;

       if(!isset($pathParts[1])|| empty($pathParts[1])){
           $action = "index";
       }else{
           $action = strtolower($pathParts[1]);
       }

       if(isset($pathParts[2])|| !empty($pathParts[2])){
            $id = (int)$pathParts[2];
        }else{
            $id = 0;
        }


       if(class_exists($controller) && method_exists($controller,$action)){
           $instanca = new $controller();
           if($id===0){
            $instanca->$action();
           }else{
            $instanca->$action($id);
           }
           
       }else{
           header("HTTP/1.0 404 Not Found");
       }



    }

    static function config($key)
    {
        $config = include BP . "app/config.php";

        return $config[$key];
    }


}

