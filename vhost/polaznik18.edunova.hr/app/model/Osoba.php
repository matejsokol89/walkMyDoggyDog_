<?php

class Osoba
{

   public static function read()
   {
       $db = Db::getInstance();
       $izraz = $db->prepare("

                   select
                   sifra,
                   ime,
                   prezime,
                   email,
                   adresa,
                   mobitel,
                   slika
                   from osoba
                   order by ime

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
        $izraz = $db->prepare("insert into osoba (ime,prezime,email,adresa,mobitel,slika)
        values (:ime,:prezime,:email,:adresa,:mobitel,:slika)");
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
        slika=:slika
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
            "slika"=>Request::post("slika")
        ];
    }


}