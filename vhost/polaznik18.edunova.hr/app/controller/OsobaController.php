<?php

class OsobaController extends ProtectedController
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
            return "Ime obavezno";
        }

        if(strlen(Request::post("ime"))>50){
            return "Ime ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from osoba where ime=:ime and sifra<>:sifra");
        $izraz->execute(["ime"=>Request::post("ime"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Ime postoji, odaberite drugi";
        }


        if(intval(Request::post("mobitel"))<=0){
            return "Mobitel nije broj ili je manje od nula";
        }

        if(Request::post("prezime")===""){
            return "Prezime obavezno";
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
        $osoba = Osoba::find($id);
        $_POST["ime"]=$osoba->ime;
        $_POST["prezime"]=$osoba->prezime;
        $_POST["email"]=$osoba->email;
        $_POST["adresa"]=$osoba->adresa;
//        $_POST["verificiran"]=$smjer->verificiran ? "on" : "";
        $_POST["mobitel"]=$osoba->mobitel;
        $_POST["slika"]=$osoba->slika;
        $_POST["pas"]=$osoba->pas;
        $_POST["sifra"]=$osoba->sifra;

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