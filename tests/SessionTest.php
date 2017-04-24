<?php

namespace Bandama\Test;

use \Bandama\Foundation\Session\Session;


class SessionTest extends \PHPUnit_Framework_TestCase {
    // Fields
    protected static $session;


    // Fixtures
    public static function setUpBeforeClass() {
        self::$session = new Session();
    }

    protected function setUp() {
    }

    protected function tearDown() {
    }

    public static function tearDownAfterClass() {
        self::$session = null;
    }


    // Tests
    public function testImplementedSessionInterface() {
        $this->assertInstanceOf('\\Bandama\\Foundation\\Session\\SessionInterface', self::$session);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetIfVariableExists() {
        self::$session->start();
        self::$session->start();
        $_SESSION['hello'] = 'world';
        $this->assertEquals('world', self::$session->get('hello'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetIfVariableNotExists() {
        self::$session->start();
        $this->assertNull(self::$session->get('toto'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testSet() {
        self::$session->start();
        self::$session->set('city', 'Abidjan');
        $this->assertEquals('Abidjan', self::$session->get('city'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testDelete() {
        self::$session->start();
        self::$session->set('city', 'Abidjan');
        $this->assertNotNull(self::$session->get('city'));
        self::$session->delete('city');
        $this->assertNull(self::$session->get('city'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetName() {
        self::$session->start();
        $this->assertEquals('PHPSESSID', self::$session->getName());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetId() {
        self::$session->start();
        $this->assertNotEmpty(self::$session->getId());
    }
}
