<?php


interface DBInterface{

    function __construct($dsn, $db_user, $db_pass);
    function query($sql, $params_arr);
    function getData($sql, $params_arr);

}

