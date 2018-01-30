<?php

require_once 'interfaces/DBInterface.php';
require_once 'abstract/DB.php';

class DBconn extends DB implements DBInterface {


    function __construct($dsn, $db_user, $db_pass){
        self::$conn = new PDO($dsn, $db_user, $db_pass);
        return self::$conn;
    }

    function query($sql, $params_arr){
        $query = self::$conn->prepare($sql);
        $result = $query->execute($params_arr);
        return $result;
    }

    function getData($sql, $params_arr){
        $query = self::$conn->prepare($sql);
        $result = $query->execute($params_arr);
        return $result->fetchAll();
    }
}

