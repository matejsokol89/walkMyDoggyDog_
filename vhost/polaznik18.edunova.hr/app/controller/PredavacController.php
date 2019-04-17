<?php

class PredavacController extends ProtectedController
{

    function delete($id)
    {
            Predavac::delete($id);
            $this->index();
    }


    function edit($id)
    {
        $_POST["sifra"]=$id;
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Predavac::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'predavaci/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    private function kontrola(){

        if(!Utillity::checkOib(Request::post("oib"))){
            return "OIB nije u dobrom formatu";
        }


        return true;
    }

    function prepareedit($id){
        $view = new View();
        $predavac = Predavac::find($id);
        $_POST = (array)$predavac;
        $view->render(
            'predavaci/edit',
            [
            "poruka"=>""
            ]
        );
    }

    function add(){
        $this->prepareedit(Predavac::add());
    }


    function index($stranica=1){
        if($stranica<=0){
            $stranica=1;
        }
        if($stranica===1){
            $prethodna=1;
        }else{
            $prethodna=$stranica-1;
        }
        $sljedeca=$stranica+1;

        $view = new View();
        $view->render(
            'predavaci/index',
            [
            "predavaci"=>Predavac::read($stranica),
            "prethodna"=>$prethodna,
            "sljedeca"=>$sljedeca
            ]
        );
    }


}