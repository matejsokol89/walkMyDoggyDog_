<?php

class Pas
{

    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("

                select 
                sifra,
                ime,
                slika
                from pas
                order by ime

       ");
        $izraz->execute();
        return $izraz->fetchAll();
    }



    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from pas where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into pas (ime,slika)
        values (:ime,:slika)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update pas set 
        ime=:ime,
        slika=:slika
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from pas where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "ime"=>Request::post("ime"),
            "slika"=>Request::post("slika")
        ];
    }


}