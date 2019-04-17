<?php

class GrupaController extends ProtectedController
{

    function dodajPolaznika()
    {

        echo Grupa::dodajPolaznika(Request::post("grupa"),Request::post("polaznik"));

    }

    function obrisiPolaznika()
    {

        echo Grupa::obrisiPolaznika(Request::post("grupa"),Request::post("polaznik"));

    }

    function edit($id)
    {
        
        $_POST["sifra"]=$id;
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Grupa::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'grupe/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
            Grupa::delete($id);
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

        if(Request::post("smjer")=="0"){
            return "Obavezno odabir smjera";
        }


        return true;
    }

    function add()
    {
        $this->prepareedit(Grupa::add());
    }

    function prepareedit($id)
    {
        $view = new View();
        $entitet = Grupa::find($id);
        $_POST["naziv"]=$entitet->naziv;
        $_POST["smjer"]=$entitet->smjer;
        $_POST["predavac"]=$entitet->predavac;
        $_POST["datumpocetka"]=$entitet->datumpocetka;
        $_POST["brojpolaznika"]=$entitet->brojpolaznika;
        $_POST["sifra"]=$entitet->sifra;

        $view->render(
            'grupe/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'grupe/index',
            [
            "grupe"=>Grupa::read()
            ]
        );
    }
}