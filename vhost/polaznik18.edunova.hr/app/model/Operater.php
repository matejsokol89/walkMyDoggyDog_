<?php

class Operater{

    public static function read(){
        $db = Db::getInstance();
        $izraz = $db->prepare("select sifra,ime,prezime,email from operater");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    


}