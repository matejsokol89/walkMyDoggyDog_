<?php

class IndexController{
    function index(){
        //echo "Hello";

        $view = new View();
        $view->render('index',["poruka"=>"Dobar dan"]);

    }
}