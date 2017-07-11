<?php

require_once './interfaces/DBInterface.php';

class Database implements DBInterface {

    private $conn;

    function __construct($dsn, $db_pass, $db_user){
        $this->pdo = new PDO($dsn, $db_pass, $db_user);
    }

    function query($sql, $params_arr){
        $this->pdo->prepare($sql);
        $result = $query->execute($params_arr);
        return $result;
    }

    function getData($sql, $params_arr){
        $query = $this->pdo->prepare($sql);
        $result = $query->execute($params_arr);
        return $result->getAssoc();
    }
}