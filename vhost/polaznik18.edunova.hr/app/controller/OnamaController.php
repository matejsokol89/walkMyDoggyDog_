<?php

class OnamaController{
    function index(){
        $view = new View();
        $view->render('onama');
    }
}