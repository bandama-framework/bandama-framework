<?php

use \Bandama\Foundation\Router\Router;


describe(Router::class, function() {
    describe('::get()', function() {
        it('add get route without name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->get('/', function() {});
            $router->get('/hello/:name', function() {});

            expect($router->getRoutes())->toContainKey('GET');
            expect($router->getRoutes()['GET'])->toHaveLength(2);
        });

        it('add get route with name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->get('/', function() {}, 'home');
            $router->get('/hello/:name', function() {}, 'hello');

            expect($router->getRoutes())->toContainKey('GET');
            expect($router->getRoutes()['GET'])->toHaveLength(2);
            expect($router->getNamedRoutes())->toContainKey('home');
            expect($router->getNamedRoutes())->toContainKey('hello');
            expect($router->getNamedRoutes())->toHaveLength(2);
        });
    });

    describe('::post()', function() {
        it('add post route without name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->post('/', function() {});
            $router->post('/hello/:name', function() {});

            expect($router->getRoutes())->toContainKey('POST');
            expect($router->getRoutes()['POST'])->toHaveLength(2);
        });

        it('add post route with name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->post('/', function() {}, 'home');
            $router->post('/hello/:name', function() {}, 'hello');

            expect($router->getRoutes())->toContainKey('POST');
            expect($router->getRoutes()['POST'])->toHaveLength(2);
            expect($router->getNamedRoutes())->toContainKey('home');
            expect($router->getNamedRoutes())->toContainKey('hello');
            expect($router->getNamedRoutes())->toHaveLength(2);
        });
    });

    describe('::put()', function() {
        it('add put route without name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->put('/', function() {});
            $router->put('/hello/:name', function() {});

            expect($router->getRoutes())->toContainKey('PUT');
            expect($router->getRoutes()['PUT'])->toHaveLength(2);
        });

        it('add put route with name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->put('/', function() {}, 'home');
            $router->put('/hello/:name', function() {}, 'hello');

            expect($router->getRoutes())->toContainKey('PUT');
            expect($router->getRoutes()['PUT'])->toHaveLength(2);
            expect($router->getNamedRoutes())->toContainKey('home');
            expect($router->getNamedRoutes())->toContainKey('hello');
            expect($router->getNamedRoutes())->toHaveLength(2);
        });
    });

    describe('::patch()', function() {
        it('add patch route without name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->patch('/', function() {});
            $router->patch('/hello/:name', function() {});

            expect($router->getRoutes())->toContainKey('PATCH');
            expect($router->getRoutes()['PATCH'])->toHaveLength(2);
        });

        it('add patch route with name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->patch('/', function() {}, 'home');
            $router->patch('/hello/:name', function() {}, 'hello');

            expect($router->getRoutes())->toContainKey('PATCH');
            expect($router->getRoutes()['PATCH'])->toHaveLength(2);
            expect($router->getNamedRoutes())->toContainKey('home');
            expect($router->getNamedRoutes())->toContainKey('hello');
            expect($router->getNamedRoutes())->toHaveLength(2);
        });
    });

    describe('::delete()', function() {
        it('add delete route without name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->delete('/', function() {});
            $router->delete('/hello/:name', function() {});

            expect($router->getRoutes())->toContainKey('DELETE');
            expect($router->getRoutes()['DELETE'])->toHaveLength(2);
        });

        it('add delete route with name', function() {
            $router = new Router();

            expect($router->getRoutes())->toBeEmpty();

            $router->delete('/', function() {}, 'home');
            $router->delete('/hello/:name', function() {}, 'hello');

            expect($router->getRoutes())->toContainKey('DELETE');
            expect($router->getRoutes()['DELETE'])->toHaveLength(2);
            expect($router->getNamedRoutes())->toContainKey('home');
            expect($router->getNamedRoutes())->toContainKey('hello');
            expect($router->getNamedRoutes())->toHaveLength(2);
        });
    });

    describe('::route()', function() {
        it('route a request to right callable', function() {
            $router = new Router();

            allow($router)->toReceive('getHttpMethod')->andReturn('GET');

            $router->get('/', 'Bandama:Test:Fake#index', 'home');
            $router->get('/hello/:name', 'Bandama:Test:Fake#hello', 'hello');

            $closure1 = function() use ($router) {
                $router->route('/');
            };

            $closure2 = function() use($router) {
                $router->route('/hello/jf');
            };

            expect($closure1)->toEcho('Hello world');
            expect($closure2)->toEcho('Hello jf');
        });
    });

    describe('::url()', function() {
        it('generate url given a route name', function() {
            $router = new Router();

            $router->delete('/', function() {}, 'home');
            $router->delete('/hello/:name', function() {}, 'hello');

            expect($router->url('home'))->toEqual('');
            expect($router->url('hello', array('name' => 'jf')))->toEqual('hello/jf');
        });
    });

});
