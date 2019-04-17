<?php

class PasController extends ProtectedController
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
            Pas::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'pas/new',
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
            Pas::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'pas/edit',
                [
                    "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
        Pas::delete($id);
        $this->index();
    }

    function kontrola()
    {
        if(Request::post("ime")===""){
            return "Ime obavezno";
        }

        if(strlen(Request::post("ime"))>50){
            return "Ime ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from pas where ime=:ime and sifra<>:sifra");
        $izraz->execute(["ime"=>Request::post("ime"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Ime postoji, odaberite drugo";
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
            'pas/new',
            [
                "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $pas = Pas::find($id);
        $_POST["ime"]=$pas->ime;
        $_POST["slika"]=$pas->slika;
        $_POST["vrsta"]=$pas->vrsta;
        $_POST["sifra"]=$pas->sifra;


        $view->render(
            'pas/edit',
            [
                "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'pas/index',
            [
                "pas"=>Pas::read()
            ]
        );
    }
}