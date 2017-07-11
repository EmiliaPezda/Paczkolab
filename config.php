<?php
include_once 'class/DBConn.php';
include_once 'class/abstract/DB.php';

<<<<<<< HEAD
+include_once 'class/DBConn.php';
+include_once 'class/abstract/DB.php';

=======
$dsn = '';
>>>>>>> da389ca9e2b7f35eda2c01fb356220edfef9cb6d
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


<<<<<<< HEAD
$setEncodingSql = "SET CHARSET utf8";
$conn->query($setEncodingSql);

=======
>>>>>>> da389ca9e2b7f35eda2c01fb356220edfef9cb6d
DB::$conn = $conn;
