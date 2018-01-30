<?php

require_once '../class/User.php';

use PHPUnit\DbUnit\TestCase;

class userTest extends TestCase{

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
        return $this->createDefaultDBConnection($this->pdo, $GLOBALS['DB_NAME']);
    }

    protected function getDataSet()
    {
        $dataMysql = $this->createMySQLXMLDataSet('./data.xml');
        return $dataMysql;
    }


    protected function setUp()
    {
        parent::setUp();
        User::SetConnection($this->pdo);
        $this->user = new User(5, 'jan', 'kowalski', 'Darłówko 15', 15, '123456');
    }

    function testLoad(){
        $this->assertFalse($this->user->load(100));
    }




}