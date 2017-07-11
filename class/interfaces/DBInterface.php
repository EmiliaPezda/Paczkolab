<?php
<<<<<<< HEAD
+
=======

>>>>>>> da389ca9e2b7f35eda2c01fb356220edfef9cb6d
interface DBInterface{
    private $conn;

    abstract function __construct($dsn, $db_pass, $db_user);
    abstract function query($sql, $params_arr);
    abstract function getData($sql, $params_arr);
<<<<<<< HEAD
+}
=======
}
>>>>>>> da389ca9e2b7f35eda2c01fb356220edfef9cb6d
