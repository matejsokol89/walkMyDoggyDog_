<?php

class Vrsta
{

    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("

                select 
                sifra,
                vrsta,
                velicina
                from vrsta
        

                
       ");
        $izraz->execute();
        return $izraz->fetchAll();
    }



    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from vrsta where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into vrsta (vrsta,velicina)
        values (:vrsta,:velicina)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update vrsta set 
        vrsta=:vrsta,
        velicina=:velicina
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from vrsta where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "vrsta"=>Request::post("vrsta"),
            "velicina"=>Request::post("velicina")
            

        ];
    }


}