<?php

class Predavac
{

    public static function delete($id)
    {
        $db = Db::getInstance();
        $db->beginTransaction();
        $izraz = $db->prepare("select osoba from predavac where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        $sifraosoba=$izraz->fetchColumn(0);
        $izraz = $db->prepare("delete from predavac where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        $izraz = $db->prepare("delete from osoba where sifra=:sifra");
        $izraz->execute(["sifra"=>$sifraosoba]);
        $db->commit();
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $db->beginTransaction();
        $izraz = $db->prepare("update osoba set 
        oib=:oib,
        ime=:ime,
        prezime=:prezime,
        email=:email 
        where sifra=:sifra");
        $izraz->execute([
            "sifra"=>$_POST["sifraosoba"],
            "oib"=>$_POST["oib"],
            "ime"=>$_POST["ime"],
            "prezime"=>$_POST["prezime"],
            "email"=>$_POST["email"]
        ]);
        $izraz = $db->prepare("update predavac set 
        iban=:iban
        where sifra=:sifra");
        $izraz->execute([
            "sifra"=>$_POST["sifra"],
            "iban"=>$_POST["iban"]
        ]);
        $db->commit();
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
                    select
                    b.sifra,
                    a.sifra as sifraosoba,
                    a.oib,
                    a.ime,
                    a.prezime,
                    a.email,
                    b.iban
                    from osoba a inner join predavac b
                    on a.sifra=b.osoba where b.sifra=:sifra;
        ");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add(){
        $db=Db::getInstance();
        $db->beginTransaction();
        $izraz=$db->prepare("insert into osoba (sifra,oib,ime,prezime,email) values
        (null,null,'','','')");
        $izraz->execute();
        $sifra = $db->lastInsertId();


        $izraz=$db->prepare("insert into predavac(sifra,osoba,iban) values 
        (null,$sifra,null)");
        $izraz->execute();

        $db->commit();
        
        return $db->lastInsertId();
    }

    public static function read($stranica=1)
    {
        $poStranici=8;
        $db = Db::getInstance();
        $izraz = $db->prepare("
                                select 
                                b.sifra, 
                                a.ime,
                                a.prezime,
                                a.email,
                                a.oib,
                                b.iban,
                                count(c.sifra) as brojgrupa
                            from osoba a 
                            inner join predavac b on a.sifra=b.osoba
                            left join grupa c on b.sifra=c.predavac
                            group by
                                b.sifra, 
                                a.ime,
                                a.prezime,
                                a.email,
                                a.oib,
                                b.iban
                            limit " . (($stranica*$poStranici) - $poStranici)  . ",$poStranici
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }



}