<?php

class Smjer
{

    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        
                    select 
                    a.sifra,
                    a.naziv,
                    a.trajanje,
                    a.cijena,
                    a.upisnina,
                    a.verificiran,
                    count(b.sifra) as ukupno from 
                    smjer a left join grupa b on a.sifra=b.smjer
                    group by 
                    a.sifra,
                    a.naziv,
                    a.trajanje,
                    a.cijena,
                    a.upisnina,
                    a.verificiran
                    order by a.naziv

        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from smjer where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into smjer (naziv,trajanje,cijena,upisnina,verificiran) 
        values (:naziv,:trajanje,:cijena,:upisnina,:verificiran)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update smjer set 
        naziv=:naziv,
        trajanje=:trajanje,
        cijena=:cijena,
        upisnina=:upisnina,
        verificiran=:verificiran
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from smjer where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "naziv"=>Request::post("naziv"),
            "trajanje"=>Request::post("trajanje"),
            "cijena"=>Request::post("cijena"),
            "upisnina"=>Request::post("upisnina"),
            "verificiran"=>Request::post("verificiran")==="on" ? true : false
        ];
    }


}