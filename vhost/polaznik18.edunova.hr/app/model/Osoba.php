<?php

class Osoba
{

   public static function read()
   {
       $db = Db::getInstance();
       $izraz = $db->prepare("

                   select
                   a.sifra,
                   a.ime,
                   a.prezime,
                   a.email,
                   a.adresa,
                   a.mobitel,
                   a.slika,
                   a.pas,
                   b.ime as pas_ime,
                   count(b.sifra) as ukupno from
                   osoba a left join pas b on a.pas=b.sifra
                   group by 
                   a.sifra,
                   a.ime,
                   a.prezime,
                   a.email,
                   a.adresa,
                   a.mobitel,
                   a.slika,
                   a.pas
                   order by a.ime

       ");
       $izraz->execute();
       return $izraz->fetchAll();
   }

    // public static function read(){
    //     $db = Db::getInstance();
    //     $izraz = $db->prepare("select sifra,ime,prezime,email,adresa,mobitel,slika from osoba");
    //     $izraz->execute();
    //     return $izraz->fetchAll();
    // }


    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from osoba where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into osoba (ime,prezime,email,adresa,mobitel,slika,pas)
        values (:ime,:prezime,:email,:adresa,:mobitel,:slika,:pas)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update osoba set 
        ime=:ime,
        prezime=:prezime,
        email=:email,
        adresa=:adresa,
        mobitel=:mobitel,
        slika=:slika,
        pas=:pas,
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from osoba where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "ime"=>Request::post("ime"),
            "prezime"=>Request::post("prezime"),
            "email"=>Request::post("email"),
            "adresa"=>Request::post("adresa"),
            "mobitel"=>Request::post("mobitel"),
            "slika"=>Request::post("slika"),
            "pas"=>Request::post("pas")
        ];
    }


}