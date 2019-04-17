<?php

class CurlController{
    function index($page){


        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, "http://athena.muo.hr/m/v1.14/?r=l&ps=12&page=" . $page);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $podaci = curl_exec($handle);
        curl_close($handle);

        $podaci = json_decode($podaci,true);
//echo "<pre>";
//print_r($podaci);
//echo "</pre>";
        if($podaci["r"]["i"]["v"]=="Data not available"){
            header("location: http://predavac01.edunova.hr/curl/index/" . --$page);
           
            exit;
        }


        $p = $podaci["r"]["bd"];
        $rezultati=[];
        foreach( $p as $k => $z){
            //echo $k . "<br />";
            $podatak=[];
            $podatak["slika"] = "http://athena.muo.hr/" . substr($podaci["r"]["br"]["r" . substr($k,1)],1);
            $podatak["detalji"] = App::config("url") . "curl/detalji/" . $podaci["r"]["bs"]["m" . substr($k,1)]["i"] ;
            //echo "<img src=\"" . "http://athena.muo.hr/" . substr($podaci["r"]["br"]["r" . substr($k,1)],1) . "\" />";
            //echo "<a href=\"" . App::config("url") . "curl/detalji/" . $podaci["r"]["bs"]["m" . substr($k,1)]["i"] . "\">detalji</a><br />";
            $metapodaci=[];
            foreach( $z as $k1 => $z1){
                //echo $k1 . "<br />";
                $metapodak=[];
                foreach( $z1 as $k2 => $z2){

                
                    switch ($k2) {
                        case 'l':
                        $metapodak["labela"] = $podaci["r"]["bl"][$z2];
                       // echo  $podaci["r"]["bl"][$z2] . ": ";
                            break;
                        
                            case 'v':
                            $metapodak["vrijednost"] =  $podaci["r"]["bm"][$z2];
                        //echo  $podaci["r"]["bm"][$z2] . "<br />";
                                break;
                    }
                    
                }
                $metapodaci[]=$metapodak;
            }
            $podatak["metapodaci"]=$metapodaci;
            $rezultati[]=$podatak;
            //echo  "<hr />";
        }




            //echo gettype($podaci);

                $prethodna=$page-1;
                if($prethodna==0){
                    $prethodna=1;
                }

                $sljedeca=$page+1;

            $view = new View();
            $view->render('curl',[
                "podaci" => $rezultati,
                "sljedeca" => $sljedeca,
                "prethodna" => $prethodna
            ]);
        }


    function detalji($id){


        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, "http://athena.muo.hr/m/v1.14/?r=i&id=" . $id);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $podaci = curl_exec($handle);
        curl_close($handle);

        $podaci = json_decode($podaci,true);
        //echo gettype($podaci);


        $view = new View();
        $view->render('curldetalji',[
            "podaci" => $podaci
        ]);
    }
}