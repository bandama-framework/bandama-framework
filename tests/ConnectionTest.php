<?php

namespace Bandama\Test;

use \Bandama\Foundation\Database\Connection;
use \PDOException;


class ConnectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException Exception
     */
    public function testGetConnectionWithException() {
        $params = array(
            'database_driver' => '',
            'database_host' => '',
            'database_port' => '',
            'database_name' => '',
            'database_user' => '',
            'database_password' => ''
        );
        $connection = new Connection($params);
        $connection->open();
    }

    /**
     * @expectedException PDOException
     */
    public function testGetConnectionWithPDOException() {
        $params = array(
            'database_driver' => 'pdo_mysql',
            'database_host' => '',
            'database_port' => '',
            'database_name' => '',
            'database_user' => '',
            'database_password' => ''
        );
        $connection = new Connection($params);
        $connection->connect();
    }

    public function testConnectToSQLite() {
        $params = array(
            'database_driver' => 'pdo_sqlite',
            'database_host' => '',
            'database_port' => '',
            'database_name' => ':memory:',
            'database_user' => '',
            'database_password' => '',
            'attributes' => array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            )
        );

        $connection = new Connection($params);
        $db = $connection->getConnection();
        $this->assertInstanceOf(\PDO::class, $db);
    }
}
