<?php

class OperaterController extends ProtectedController{

    public function __construct(){
        if(!Session::getInstance()->isLogiran()){
            $view = new View();
            $view->render('index',["poruka"=>"Nemate ovlasti"]);
            exit;
        }
    }

   


    function index(){
        $view = new View();
        $view->render(
            'operateri/index',
            [
            "operateri"=>Operater::read()
            ]
        );
    }
}