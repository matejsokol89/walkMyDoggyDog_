<?php

class KontaktController{
    function index(){
        $view = new View();
        $view->render('kontakt');
    }
}