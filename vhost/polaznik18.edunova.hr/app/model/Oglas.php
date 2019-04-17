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
       a.opis,
       a.datumOglasa,
       a.slika,
       a.aktivan,
       a.osoba,
       b.ime as osoba_ime
       from oglas a left join
       osoba b on a.osoba=b.sifra 
       group by
       a.sifra,
       a.naziv,
       a.opis,
       a.datumOglasa,
       a.slika,
       a.aktivan,
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
        $izraz = $db->prepare("insert into oglas (naziv,opis,datumOglasa,slika,aktivan,osoba)
        values (:naziv,:opis,:datumOglasa,:slika,aktivan,:osoba)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update oglas set 
        naziv=:naziv,
        opis=:opis,
        datumOglasa=:datumOglasa,
        slika=:slika,
        aktivan=:aktivan,
        osoba=:osoba
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
            "opis"=>Request::post("opis"),
            "datumOglasa"=>Request::post("datumOglasa"),
            "slika"=>Request::post("slika"),
            // "aktivan"=>Request::post("aktivan"),
            "aktivan"=>Request::post("aktivan")==="on" ? true : false,
            "osoba"=>Request::post("osoba")
         
        ];
    }


}