<?php
namespace modules\uloleorm;

class SQL { 
    public static $databases = [];
    public $con;
    function __construct($username, $password=false, $database=false,$host=false,$port=3306, $driver="mysql") {
        if ( ($password === false) && ($database === false) && ($host === false) ) {
            $db_username  =  $username["username"];
            $db_password  =  $username["password"];
            $db_database  =  $username["database"];
            $db_host      =  $username["server"];
            $db_driver    =  $username["driver"];
        } else {
            $db_username  =  $username;
            $db_password  =  $password;
            $db_database  =  $database;
            $db_host      =  $host;
            $db_driver    =  $driver;
        }
        if ($db_driver=="sqlite")
            $this->con = new \PDO($db_driver.':'.$db_database);
        else
            $this->con = new \PDO($db_driver.':host='.$db_host.';dbname='.$db_database, $db_username, $db_password);
    }

    function getObject() {
        return $this->con;
    }
}
