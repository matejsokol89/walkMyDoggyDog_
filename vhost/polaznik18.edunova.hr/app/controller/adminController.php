<?php

class AdminController
{
    function prijava()
    {
        $view = new View();
        $view->render('prijava',["poruka"=>""]);
    }

    function login()
    {
        //nedostaje konkretan login

        $db=Db::getInstance();
        $izraz = $db->prepare("select ime,prezime, email,lozinka from operater where email=:email");
        $izraz->execute(["email"=>Request::post("email")]);

        $view = new View();

        if($izraz->rowCount()>0){
            $red=$izraz->fetch();
            if(password_verify(Request::post("password"),$red->lozinka)){
                $user = new stdClass();
                $user->ime=$red->ime;
                $user->prezime=$red->prezime;
                $user->role=$red->role;
                $user->email=$red->email;
                $user->imePrezime=$red->ime . " " . $red->prezime;

                Session::getInstance()->login($user);

                $view->render('index',["poruka"=>"Uspješno prijavljen"]);
            }else{
                $view->render('prijava',["poruka"=>"Kombinacija email i lozinka ne odgovara"]);
            }
        }else{
            $view->render('prijava',["poruka"=>"Ne postojeći email"]);
        }

        

        //
        
    }

    function odjava()
    {

        Session::getInstance()->odjava();
        $view = new View();
        $view->render('index',["poruka"=>""]);
    }

    function registration()
    {
        $view = new View();
        $view->render('registration',["message"=>""]);
    }
    function register()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into operater (ime,prezime,email,lozinka) values (:ime,:prezime,:email,:lozinka)");
        $izraz->bindValue('ime', Request::post("ime"));
        $izraz->bindValue('prezime', Request::post("prezime"));
        $izraz->bindValue('email', Request::post("email"));
        $izraz->bindValue('lozinka', password_hash(Request::post("password"),PASSWORD_DEFAULT));
        $izraz->execute();
        Session::getInstance()->odjava();
        $view = new View();
        $view->render('login',["message"=>"Success"]);
    }
}