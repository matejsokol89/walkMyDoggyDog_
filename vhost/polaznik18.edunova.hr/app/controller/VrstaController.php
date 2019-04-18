<?php

class VrstaController extends ProtectedController
{

    public function __construct()
    {
        if(!Session::getInstance()->isLogiran()){
            $view = new View();
            $view->render('index',["poruka"=>"Nemate ovlasti"]);
            exit;
        }
    }

    function add()
    {

        $kontrola = $this->kontrola();
        if($kontrola===true){
            Vrsta::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'vrsta/new',
                [
                    "poruka"=>$kontrola
                ]
            );
        }

    }

    function edit($id)
    {
        $_POST["sifra"]=$id;
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Vrsta::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'vrsta/edit',
                [
                    "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
        Vrsta::delete($id);
        $this->index();
    }

    function kontrola()
    {
        if(Request::post("vrsta")===""){
            return "Vrsta obavezna";
        }

        if(strlen(Request::post("vrsta"))>50){
            return "Vrsta ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from vrsta where vrsta=:vrsta and sifra<>:sifra");
        $izraz->execute(["vrsta"=>Request::post("vrsta"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Vrsta postoji, odaberite drugu";
        }

//
//        if(Request::post("velicina")===""){
//            return "Velicina obavezna";
//        }


        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'vrsta/new',
            [
                "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $vrsta = Vrsta::find($id);
        $_POST["vrsta"]=$vrsta->vrsta;
        $_POST["velicina"]=$vrsta->velicina;
        $_POST["sifra"]=$vrsta->sifra;

 


        $view->render(
            'vrsta/edit',
            [
                "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'vrsta/index',
            [
                "vrsta"=>Vrsta::read()
            ]
        );
    }
}