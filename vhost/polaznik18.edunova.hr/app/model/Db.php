<?php


class Db extends PDO{

    private static $instance;

    public function __construct($config)
    {

        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['name'].';charset=utf8';

        parent::__construct($dsn,$config['user'],$config['password']);

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    }


    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self(App::config("db"));
        }

        return self::$instance;
    }


}