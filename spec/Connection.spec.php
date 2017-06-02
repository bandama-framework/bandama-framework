<?php

use \Bandama\Foundation\Database\Connection;


describe(Connection::class, function() {

    it('should throw Expection when database driver is not defined or is wrong', function() {
        $closure = function() {
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
        };

        expect($closure)->toThrow(new Exception());
    });

    it('should throw PDOException when database parameters are wrong', function() {
        $closure = function() {
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
        };

        expect($closure)->toThrow(new PDOException());
    });

    it('should connect to database', function() {
        $params = array(
            'database_driver' => 'pdo_sqlite',
            'database_host' => '',
            'database_port' => '',
            'database_name' => ':memory:',
            'database_user' => '',
            'database_password' => '',
            'attributes' => array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );

        $connection = new Connection($params);
        $db = $connection->getConnection();
        expect($db)->toBeAnInstanceOf(PDO::class);
        expect($connection->getPDO())->toBe($db);
        expect($connection->getDriver())->toEqual($params['database_driver']);
        expect($connection->getHost())->toEqual($params['database_host']);
        expect($connection->getPort())->toEqual($params['database_port']);
        expect($connection->getDatabase())->toEqual($params['database_name']);
        expect($connection->getUser())->toEqual($params['database_user']);
        expect($connection->getAttributes())->not->toBeEmpty();
        expect($connection->getAttributes())->toContainKey(PDO::ATTR_ERRMODE);
    });

});
