<?php

class OglasController extends ProtectedController
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
            Oglas::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'oglas/new',
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
            Oglas::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'oglas/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
            Oglas::delete($id);
            $this->index();
    }

    function kontrola()
    {
        if(Request::post("naziv")===""){
            return "Naziv oglasa je obavezan";
        }

        if(strlen(Request::post("naziv"))>50){
            return "Naziv ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from osoba where ime=:ime and sifra<>:sifra");
        $izraz->execute(["ime"=>Request::post("ime"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Ime postoji, odaberite drugi";
        }


        if(intval(Request::post("datumOglasa"))<=0){
            return "Mobitel nije broj ili je manje od nula";
        }

        if(Request::post("opis")===""){
            return "Opis je obavezan";
        }


        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'oglas/new',
            [
            "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $oglas = Oglas::find($id);
        $_POST["naziv"]=$oglas->naziv;
        $_POST["opis"]=$oglas->opis;
        $_POST["datumOglasa"]=$oglas->datumOglasa;
//        $_POST["verificiran"]=$smjer->verificiran ? "on" : "";
        $_POST["slika"]=$oglas->slika;
        $_POST["aktivan"]=$oglas->aktivan;
        $_POST["osoba"]=$oglas->osoba;
        //$_POST["sifra"]=$oglas->sifra;

        $view->render(
            'oglas/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'oglas/index',
            [
            "oglas"=>Oglas::read()
            ]
        );
    }
}