<?php

namespace Bandama\Test;

use \Bandama\App;


class AppTest extends \PHPUnit_Framework_TestCase {
    // Fields
    protected static $app;

    // Tests
    /**
     * @runInSeparateProcess
     */
    public function testInitializationAndAddService() {
        // Initialization Tests
        self::$app = App::getInstance();

        $this->assertNotNull(self::$app->getContainer());
        $this->assertEquals(App::APP_MODE_PROD, self::$app->getMode());
        $this->assertNull(self::$app->getConfigFile());
        $this->assertNotNull(self::$app->get('config'));
        $this->assertNotNull(self::$app->get('session'));
        $this->assertNotNull(self::$app->get('router'));
        $this->assertNotNull(self::$app->get('cookie'));
        $this->assertNotNull(self::$app->get('flash'));

        // AddService Tests
        self::$app->addService('fakeService', 'Bandama:Test:FakeService');
        $service = self::$app->get('fakeService');
        $this->assertNotNull($service);
        $this->assertInstanceOf(\Bandama\Test\FakeService::class, $service);
        $this->assertEquals('Hello world', $service->hello('world'));
    }
}
