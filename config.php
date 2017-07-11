<?php
include_once 'class/DBConn.php';
include_once 'class/abstract/DB.php';

$dsn = '';
$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "Paczkolab";
//
//$conn = new mysqli($servername, $username, $password, $baseName);
//
//if ($conn->connect_error) {
//    echo "Connection failed. Error: " . $conn->connect_error;
//    die;
//}
//
//$setEncodingSql = "SET CHARSET utf8";
//$conn->query($setEncodingSql);

$conn = new DBConn($dsn, $password, $username);


DB::$conn = $conn;
