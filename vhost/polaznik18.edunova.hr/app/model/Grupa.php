<?php

class Grupa
{

    public static function dodajPolaznika($grupa,$polaznik)
    {
        $db = Db::getInstance();
        $db->beginTransaction();

        $izraz = $db->prepare("
                 select count(*) from clan where grupa=:grupa and polaznik=:polaznik;
        ");
        $izraz->execute(["grupa"=>$grupa, "polaznik"=>$polaznik]);
        $ukupno = $izraz->fetchColumn();
        $vrati="";
        if($ukupno>0){
            $vrati= "Polaznik postoji na grupi, nije dodan";
        }else{
            $izraz = $db->prepare("
            insert into clan(grupa,polaznik) values (:grupa,:polaznik);
            ");
            $izraz->execute(["grupa"=>$grupa, "polaznik"=>$polaznik]);
            $vrati="OK";
        }

        
        $db->commit();
        return $vrati;
    }


    public static function obrisiPolaznika($grupa,$polaznik)
    {
        $db = Db::getInstance();

        $izraz = $db->prepare("
                delete from clan where grupa=:grupa and polaznik=:polaznik;
        ");
        $izraz->execute(["grupa"=>$grupa, "polaznik"=>$polaznik]);
       
        return "OK";
    }

    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        
                  select 
                  a.sifra,
                  a.naziv,
                  b.naziv as smjer,
                  concat(d.ime, ' ',d.prezime) as predavac,
                  a.datumpocetka,
                  count(e.polaznik) as ukupno
                  from grupa a 
                  left join smjer      b on a.smjer    =b.sifra
                  left join predavac   c on a.predavac =c.sifra
                  left join osoba      d on c.osoba    =d.sifra
                  left join clan        e on a.sifra    =e.grupa
                  group by a.sifra,a.naziv,b.naziv,concat(d.ime, ' ',d.prezime),a.datumpocetka

        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from grupa where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }
//mjenjati nadolje
    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into grupa (naziv,smjer,predavac,datumpocetka, brojpolaznika) 
        values ('',null,null,now(),null)");
        $izraz->execute();
        return $db->lastInsertId();
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update grupa set 
        naziv=:naziv,
        smjer=:smjer,
        predavac=:predavac,
        datumpocetka=:datumpocetka,
        brojpolaznika=:brojpolaznika
        where sifra=:sifra");
        
        $izraz->bindParam("naziv",Request::post("naziv"),PDO::PARAM_STR);
        $izraz->bindParam("smjer",Request::post("smjer"),PDO::PARAM_INT);

        if(Request::post("predavac")=="0"){
            $izraz->bindValue("predavac",null,PDO::PARAM_NULL);
        }else{
            $izraz->bindParam("predavac",Request::post("predavac"),PDO::PARAM_INT);
        }

        if(Request::post("datumpocetka")==""){
            $izraz->bindValue("datumpocetka",null,PDO::PARAM_NULL);
        }else{
            $izraz->bindParam("datumpocetka",Request::post("datumpocetka"),PDO::PARAM_STR);
        }

        $izraz->bindParam("brojpolaznika",Request::post("brojpolaznika"),PDO::PARAM_INT);

        $izraz->bindParam("sifra",$id,PDO::PARAM_INT);


        $izraz->execute();
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from grupa where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

}