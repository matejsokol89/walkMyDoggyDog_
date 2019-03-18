<?php

class Oglas
{

   public static function read()
   {
       $db = Db::getInstance();
       $izraz = $db->prepare("

                    select
                    a.sifra,
                    a.naziv,
                    a.datumOglasa,
                    a.slika,
                    a.aktivan,
                    a.pas,
                    a.osoba,
                    b.ime as osoba_ime,
                    c.ime as pas_ime,
                    count(b.sifra) as ukupno from
                    oglas a left join osoba b on a.osoba=b.sifra 
                    left join pas c on a.pas=c.sifra
                    group by
                    a.sifra,
                    a.naziv,
                    a.datumOglasa,
                    a.slika,
                    a.aktivan,
                    a.pas,
                    a.osoba
                    order by a.naziv

       ");
       $izraz->execute();
       return $izraz->fetchAll();
   }

   public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from oglas where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into oglas (naziv,datumOglasa,aktivan,slika,pas,osoba)
        values (:naziv,:datumOglasa,:aktivan,:slika,:pas,:osoba)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update oglas set 
        naziv=:naziv,
        datumOglasa=:datumOglasa,
        aktivan=:aktivan,
        slika=:slika,
        pas=:pas,
        osoba=:osoba,
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from oglas where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "naziv"=>Request::post("naziv"),
            "datumOglasa"=>Request::post("datumOglasa"),
            "slika"=>Request::post("slika"),
            // "aktivan"=>Request::post("aktivan"),
            "aktivan"=>Request::post("aktivan")==="on" ? true : false,
            "pas"=>Request::post("pas"),
            "osoba"=>Request::post("osoba")
         
        ];
    }


}