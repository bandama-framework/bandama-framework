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
        $connection->getConnection();
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
        $connection->getConnection();
    }

}
