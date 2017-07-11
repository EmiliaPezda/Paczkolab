<?php
include_once 'class/DBConn.php';
include_once 'class/abstract/DB.php';

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "Paczkolab";

$dsn = "mysql:host=$servername;dbname=$baseName;charset=utf8";


$conn = new DBConn($dsn, $username, $password);



DB::$conn = $conn;
