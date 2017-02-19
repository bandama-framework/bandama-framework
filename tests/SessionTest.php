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

    public function testStart() {
        $this->assertEmpty(self::$session->getId());
        self::$session->start();
        $this->assertNotNull(self::$session->getId());
    }

    /**
     * @depends testStart
     */
    public function testGetIfVariableExists() {
        $_SESSION['hello'] = 'world';
        $this->assertEquals('world', self::$session->get('hello'));
    }

    /**
     * @depends testStart
     */
    public function testGetIfVariableNotExists() {
        $this->assertNull(self::$session->get('toto'));
    }

    /**
     * @depends testStart
     */
    public function testSet() {
        self::$session->set('city', 'Abidjan');
        $this->assertEquals('Abidjan', self::$session->get('city'));
    }

    /**
     * @depends testStart
     */
    public function testDelete() {
        self::$session->set('city', 'Abidjan');
        $this->assertNotNull(self::$session->get('city'));
        self::$session->delete('city');
        $this->assertNull(self::$session->get('city'));
    }

    /**
     * @depends testStart
     */
    public function testGetName() {
        $this->assertEquals('PHPSESSID', self::$session->getName());
    }

    /**
     * @depends testStart
     */
    public function testGetId() {
        $this->assertNotEmpty(self::$session->getId());
    }

    /**
     * @depends testStart
     */
    public function testDestroy() {
        self::$session->set('city', 'Abidjan');
        self::$session->destroy();
        $this->assertEquals(0, count($_SESSION));
    }

    public function testStartWithArgs() {
        self::$session->start('hello');
        $this->assertEquals('hello', self::$session->getName());
        self::$session->destroy();
        self::$session->start('hello', '1234567890');
        $this->assertEquals('hello', self::$session->getName());
        $this->assertEquals('1234567890', self::$session->getId());
        self::$session->destroy();

        $params = array(
            ''
        )
    }
}
