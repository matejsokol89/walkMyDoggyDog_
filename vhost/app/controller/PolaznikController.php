<?php

class PolaznikController extends ProtectedController
{


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
            'polaznici/index',
            [
            "polaznici"=>Polaznik::read($stranica),
            "prethodna"=>$prethodna,
            "sljedeca"=>$sljedeca
            ]
        );
    }


   public function __bulkinsert()
   {

    $db = Db::getInstance();

    $db->beginTransaction();
    for($i=1;$i<=2225;$i++){
        $izraz = $db->prepare("insert into osoba (sifra,oib,ime,prezime,email) values
        (null,null,'Polaznik','$i','polaznik$i@gmail.com')");
        $izraz->execute();
        $zadnjaOsobaSifra = $db->lastInsertId();
        $izraz = $db->prepare("insert into polaznik(sifra,osoba,brojugovora) values 
        (null,$zadnjaOsobaSifra,null)");
        $izraz->execute();
        
    }
    $db->commit();
    echo "Sve OK";
   } 
}