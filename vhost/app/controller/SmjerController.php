<?php

class SmjerController
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
            Smjer::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'smjerovi/new',
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
            Smjer::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'smjerovi/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
            Smjer::delete($id);
            $this->index();
    }

    function kontrola()
    {
        if(Request::post("naziv")===""){
            return "Naziv obavezno";
        }

        if(strlen(Request::post("naziv"))>50){
            return "Naziv ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from smjer where naziv=:naziv and sifra<>:sifra");
        $izraz->execute(["naziv"=>Request::post("naziv"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Naziv postoji, odaberite drugi";
        }


        if(intval(Request::post("trajanje"))<=0){
            return "Trajanje nije broj ili je manje od nula";
        }

        if(Request::post("cijena")===""){
            return "Cijena obavezno";
        }


        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'smjerovi/new',
            [
            "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $smjer = Smjer::find($id);
        $_POST["naziv"]=$smjer->naziv;
        $_POST["trajanje"]=$smjer->trajanje;
        $_POST["cijena"]=$smjer->cijena;
        $_POST["upisnina"]=$smjer->upisnina;
        $_POST["verificiran"]=$smjer->verificiran ? "on" : "";
        $_POST["sifra"]=$smjer->sifra;

        $view->render(
            'smjerovi/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'smjerovi/index',
            [
            "smjerovi"=>Smjer::read()
            ]
        );
    }
}