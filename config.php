<?php
include_once 'class/DBConn.php';
include_once 'class/abstract/DB.php';

$servername = "localhost";
$username = "root";
$password = "yourpassword";
$baseName = "Paczkolab";

$dsn = "mysql:host=$servername;dbname=$baseName;charset=utf8";



$conn = new PDO($dsn, $username, $password);


DB::$conn = $conn;

if ($conn->errorCode() != null) {
    var_dump($conn->errorInfo());
    die();
}

