<?php

require_once './../class/User.php';

use PHPUnit\DbUnit\TestCase;

class UserTests extends TestCase{

    private $user;
    private $pdo;

    function __construct(){
        parent::__construct();
        $this->pdo = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
    }

    protected function getConnection()
    {
        return $this->createDefaultDBConnection($this->pdo,    $GLOBALS['DB_NAME']);
    }

    protected function getDataSet()
    {
        $dataMysql = $this->createMySQLXMLDataSet('./phpunit.xml');
        return $dataMysql;
    }


    protected function setUp()
    {
        $this->user = new User(0, 'jan', 'kowalski', 'Darłówko 15', 15, '123456');
    }

    function testLoad(){
        $this->assertNull( $this->user->load(10));
    }




}