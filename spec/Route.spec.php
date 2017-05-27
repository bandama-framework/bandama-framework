<?php

use Bandama\Foundation\Router\Route;


describe(Route::class, function() {

    describe('::__construct()', function() {
        it('initialize with differents paramaters', function() {
            $callable = function() {};
            $route = new Route('/', $callable);

            expect($route->getPath())->toEqual('');
            expect($route->getCallable())->toEqual($callable);

            $route = new Route('/hello/:name', 'callable');

            expect($route->getPath())->toEqual('hello/:name');
            expect($route->getCallable())->toEqual('callable');
        });
    });

    describe('::with()', function() {
        it('add with content in params array', function() {
            $route = new Route('hello/:name', function($name) {
            });
            $route->with('name', '[a-zA-Z0-9-]+');

            expect($route->getParams())->toContainKey('name');
        });
    });

    describe('::match()', function() {
        it('test match() method with different parameters', function() {
            $route1 = new Route('/', function(){});
            $route2 = new Route('hello/:name', function($name) {
            });
            $route2->with('name', '[a-zA-Z0-9-]+');

            expect($route1->match('/posts'))->toBeFalsy();
            expect($route1->match(''))->toBeEmpty();
            expect($route1->match('/'))->toBeEmpty();

            expect($route2->match('/posts'))->toBeFalsy();
            expect($route2->match('/hello/jf'))->not->toBeEmpty();
            expect($route2->match('/hello/jf'))->toEqual(array('jf'));
        });
    });

    describe('::execute()', function() {
        it('execute without controller', function() {
            $action1 = function() {
                echo 'Hello world';
            };

            $action2 = function($name) {
                echo "Hello $name";
            };

            $route1 = new Route('/', $action1);
            $route2 = new Route('hello/:name', $action2);
            $route2->with('name', '[a-zA-Z0-9-]+');
        });

        it('execute with controller', function() {
            $route1 = new Route('/fake', 'Bandama:Test:Fake#index');
            $route2 = new Route('/fake/:name', 'Bandama:Test:Fake#hello');

            $closure1 = function() use($route1) {
                $route1->execute(array());
            };

            $closure2 = function() use($route2) {
                $route2->execute(array('name' => 'jf'));
            };

            expect($closure1)->toEcho('Hello world');
            expect($closure2)->toEcho('Hello jf');
        });
    });

    describe('::getUrl()', function() {
        it('generate an url based on route name', function() {
            $route1 = new Route('/', function(){});
            $route2 = new Route('hello/:name', function($name) {
            });
            $route2->with('name', '[a-zA-Z0-9-]+');

            expect($route1->getUrl(array()))->toEqual('');
            expect($route2->getUrl(array('name' => 'jf')))->toEqual('hello/jf');
        });
    });

});
