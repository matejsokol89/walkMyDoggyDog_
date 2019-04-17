<?php

class Polaznik
{

    public static function read($stranica)
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
                                b.brojugovora,
                                count(c.grupa) as brojgrupa
                            from osoba a 
                            inner join polaznik b on a.sifra=b.osoba
                            left join clan c on b.sifra=c.polaznik
                            group by
                                b.sifra, 
                                a.ime,
                                a.prezime,
                                a.email,
                                a.oib,
                                b.brojugovora
                            limit " . (($stranica*$poStranici) - $poStranici)  . ",$poStranici
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }



}