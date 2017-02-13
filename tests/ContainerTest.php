<?php

namespace Bandama\Test;

use \Bandama\Foundation\DependencyInjection\Container;


class ContainerTest extends \PHPUnit_Framework_TestCase {

    public function testInitialization() {
        $container = new Container();

        $this->assertEmpty($container->getRegistry());
        $this->assertEmpty($container->getFactories());
        $this->assertEmpty($container->getInstances());
    }

    public function testSet() {
        $container = new Container();

        $container->set('controller', function() {
            return new FakeController();
        });

        $controller1 = $container->get('controller');
        $controller2 = $container->get('controller');

        $this->assertInstanceOf('Bandama\\Test\\FakeController', $controller1);
        $this->assertSame($controller1, $controller2);
    }

    public function testSetFactory() {
        $container = new Container();

        $container->setFactory('controller', function() {
            return new FakeController();
        });

        $controller1 = $container->get('controller');
        $controller2 = $container->get('controller');

        $this->assertInstanceOf(FakeController::class, $controller1);
        $this->assertNotSame($controller1, $controller2);
    }

    public function testSetInstance() {
        $container = new Container();

        $controller = new FakeController();

        $container->setInstance($controller);

        $this->assertInstanceOf(FakeController::class, $container->get('Bandama:Test:FakeController'));
        $this->assertSame($controller, $container->get('Bandama:Test:FakeController'));
    }

    /**
     * @expectedException ReflectionException
     */
    public function testGetWithReflexionException() {
        $container = new Container();

        $controller = new FakeController();

        $container->setInstance($controller);

        $container->get('FakeController');
    }

    /**
     * @expectedException Exception
     */
    public function testGetWithException() {
        $container = new Container();

        $container->get('FakeController');
    }

    public function testGetWithNotRegisteredElement() {
        $container = new Container();

        $this->assertInstanceOf(FakeController::class, $container->get('Bandama:Test:FakeController'));
    }
}
