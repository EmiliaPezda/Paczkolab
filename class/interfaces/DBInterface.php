<?php


interface DBInterface{
    private $conn;

    abstract function __construct($dsn, $db_pass, $db_user);
    abstract function query($sql, $params_arr);
    abstract function getData($sql, $params_arr);


}

