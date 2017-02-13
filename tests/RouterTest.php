<?php

namespace Bandama\Test;

use \Bandama\Foundation\Router\Router;


class RouterTest extends \PHPUnit_Framework_TestCase {

    public function testGetWithoutName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->get('/', function() {});
        $router->get('/hello/:name', function() {});

        $this->assertArrayHasKey('GET', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['GET']);
    }

    public function testGetWithName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->get('/', function() {}, 'home');
        $router->get('/hello/:name', function() {}, 'hello');

        $this->assertArrayHasKey('GET', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['GET']);
        $this->assertArrayHasKey('home', $router->getNamedRoutes());
        $this->assertArrayHasKey('hello', $router->getNamedRoutes());
        $this->assertCount(2, $router->getNamedRoutes());
    }

    public function testPostWithoutName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->post('/', function() {});
        $router->post('/hello/:name', function() {});

        $this->assertArrayHasKey('POST', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['POST']);
    }

    public function testPostWithName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->post('/', function() {}, 'home');
        $router->post('/hello/:name', function() {}, 'hello');

        $this->assertArrayHasKey('POST', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['POST']);
        $this->assertArrayHasKey('home', $router->getNamedRoutes());
        $this->assertArrayHasKey('hello', $router->getNamedRoutes());
        $this->assertCount(2, $router->getNamedRoutes());
    }

    public function testPutWithoutName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->put('/', function() {});
        $router->put('/hello/:name', function() {});

        $this->assertArrayHasKey('PUT', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['PUT']);
    }

    public function testPutWithName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->put('/', function() {}, 'home');
        $router->put('/hello/:name', function() {}, 'hello');

        $this->assertArrayHasKey('PUT', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['PUT']);
        $this->assertArrayHasKey('home', $router->getNamedRoutes());
        $this->assertArrayHasKey('hello', $router->getNamedRoutes());
        $this->assertCount(2, $router->getNamedRoutes());
    }

    public function testDeleteWithoutName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->delete('/', function() {});
        $router->delete('/hello/:name', function() {});

        $this->assertArrayHasKey('DELETE', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['DELETE']);
    }

    public function testDeleteWithName() {
        $router = new Router();

        $this->assertEmpty($router->getRoutes());

        $router->delete('/', function() {}, 'home');
        $router->delete('/hello/:name', function() {}, 'hello');

        $this->assertArrayHasKey('DELETE', $router->getRoutes());
        $this->assertCount(2, $router->getRoutes()['DELETE']);
        $this->assertArrayHasKey('home', $router->getNamedRoutes());
        $this->assertArrayHasKey('hello', $router->getNamedRoutes());
        $this->assertCount(2, $router->getNamedRoutes());
    }

    /*public function testRoute() {
        $router = new Router();

        $router->delete('/', 'Bandama:Test:Fake#index', 'home');
        $router->delete('/hello/:name', 'Bandama:Test:Fake#hello', 'hello');

        ob_start();
        $router->route('/');
        $content = ob_get_clean();

        $this->assertEquals('Hello world', $content);

        ob_start();
        $router->route('/hello/jf');
        $content = ob_get_clean();

        $this->assertEquals('Hello jf', $content);
    }*/

    public function testUrl() {
        $router = new Router();

        $router->delete('/', function() {}, 'home');
        $router->delete('/hello/:name', function() {}, 'hello');

        $this->assertEquals('', $router->url('home'));
        $this->assertEquals('hello/jf', $router->url('hello', array('name' => 'jf')));
    }
}
