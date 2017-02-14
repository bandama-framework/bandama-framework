<?php

namespace Bandama\Test;

use Bandama\Foundation\Router\Route;


class RouteTest extends \PHPUnit_Framework_TestCase {

    public function testConstructor() {
        $callable = function() {};
        $route = new Route('/', $callable);

        $this->assertEquals('', $route->getPath());
        $this->assertEquals($callable, $route->getCallable());

        $route = new Route('/hello/:name', 'callable');

        $this->assertEquals('hello/:name', $route->getPath());
        $this->assertEquals('callable', $route->getCallable());
    }

    public function testWith() {
        $route = new Route('hello/:name', function($name) {
        });
        $route->with('name', '[a-zA-Z0-9-]+');

        $this->assertArrayHasKey('name', $route->getParams());
    }

    public function testMatch() {
        $route1 = new Route('/', function(){});
        $route2 = new Route('hello/:name', function($name) {
        });
        $route2->with('name', '[a-zA-Z0-9-]+');

        $this->assertFalse($route1->match('/posts'));
        $this->assertEmpty($route1->match(''));
        $this->assertEmpty($route1->match('/'));

        $this->assertFalse($route2->match('/posts'));
        $this->assertNotEmpty($route2->match('/hello/jf'));
        $this->assertEquals($route2->match('/hello/jf'), array('jf'));
    }

    public function testExecuteWithoutController() {
        $action1 = function() {
            return 'Hello world';
        };

        $action2 = function($name) {
            return "Hello $name";
        };

        $route1 = new Route('/', $action1);
        $route2 = new Route('hello/:name', $action2);
        $route2->with('name', '[a-zA-Z0-9-]+');


        $this->assertEquals('Hello world', $route1->execute(array()));
        $this->assertEquals('Hello jf', $route2->execute(array('name' => 'jf')));

    }

    public function testExecuteWithController() {
        $route1 = new Route('/fake', 'Bandama:Test:Fake#index');
        $route2 = new Route('/fake/:name', 'Bandama:Test:Fake#hello');

        $this->assertEquals('home', $route1->execute(array()));
        $this->assertEquals('Hello jf', $route2->execute(array('name' => 'jf')));
    }

    public function testGetUrl() {
        $route1 = new Route('/', function(){});
        $route2 = new Route('hello/:name', function($name) {
        });
        $route2->with('name', '[a-zA-Z0-9-]+');

        $this->assertEquals('', $route1->getUrl(array()));
        $this->assertEquals('hello/jf', $route2->getUrl(array('name' => 'jf')));
    }

}
