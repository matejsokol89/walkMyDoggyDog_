<?php

class OsobaController
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
            Osoba::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'osoba/new',
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
            Osoba::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'osoba/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
            Osoba::delete($id);
            $this->index();
    }

    function kontrola()
    {
        if(Request::post("ime")===""){
            return "Naziv obavezno";
        }

        if(strlen(Request::post("ime"))>50){
            return "Naziv ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from osoba where ime=:ime and sifra<>:sifra");
        $izraz->execute(["ime"=>Request::post("ime"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Naziv postoji, odaberite drugi";
        }


        if(intval(Request::post("mobitel"))<=0){
            return "Trajanje nije broj ili je manje od nula";
        }

        if(Request::post("prezime")===""){
            return "Cijena obavezno";
        }


        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'osoba/new',
            [
            "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $smjer = Osoba::find($id);
        $_POST["ime"]=$smjer->ime;
        $_POST["prezime"]=$smjer->prezime;
        $_POST["email"]=$smjer->email;
        $_POST["adresa"]=$smjer->adresa;
//        $_POST["verificiran"]=$smjer->verificiran ? "on" : "";
        $_POST["mobitel"]=$smjer->mobitel;
        $_POST["slika"]=$smjer->slika;
        $_POST["sifra"]=$smjer->sifra;

        $view->render(
            'osoba/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'osoba/index',
            [
            "osoba"=>Osoba::read()
            ]
        );
    }
}