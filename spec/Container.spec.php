<?php

use \Bandama\Foundation\DependencyInjection\Container;
use \Bandama\Test\FakeController;
use \Bandama\Test\FakeAddress;


describe(Container::class, function() {

    given('container', function() {
        return new Container();
    });

    it('registry, factory and instance collection are empty', function() {
        expect($this->container->getRegistry())->toBeEmpty();
        expect($this->container->getFactories())->toBeEmpty();
        expect($this->container->getInstances())->toBeEmpty();
    });

    describe('::get()', function() {
        it('should throw an ReflectionException', function() {
            $closure = function() {
                $this->container->get('FakeController');
            };

            expect($closure)->toThrow();
        });

        it('get with not registered element with default constructor', function() {
            expect($this->container->get('Bandama:Test:FakeController'))->toBeAnInstanceOf(FakeController::class);
        });

        it('get with not registered element with no default constructor', function() {
            expect($this->container->get('Bandama:Test:FakePerson')->getAddress())->toBeAnInstanceOf(FakeAddress::class);
        });

        it('should an Expection when we try to get an object from not instanciable class', function() {
            $closure = function() {
                $this->container->get('Bandama:Test:FakeNotInstanciable');
            };

            expect($closure)->toThrow();
        });

        it('get with parametrized constructor class', function() {
            $obj = $this->container->get('Bandama:Test:FakeParametrizedConstructor');

            expect($obj->getId())->toEqual(0);
            expect($obj->getName())->toEqual('');
        });
    });

    describe('::set()', function() {
        it('add an object to registry and return the same object with get() method', function() {
            $this->container->set('controller', function() {
                return new FakeController();
            });

            $controller1 = $this->container->get('controller');
            $controller2 = $this->container->get('controller');

            expect($controller1)->toBe($controller2);
        });
    });

    describe('::setFactory()', function() {
        it('add an object to factories and return a new instance with get() method', function() {
            $this->container->setFactory('controller', function() {
                return new FakeController();
            });

            $controller1 = $this->container->get('controller');
            $controller2 = $this->container->get('controller');

            expect($controller1)->toEqual($controller2);
        });
    });

    describe('::setInstance()', function() {
        it('add an instance to instances and return it with get() method', function() {
            $controller = new FakeController();

            $this->container->setInstance($controller);

            expect($this->container->get('Bandama:Test:FakeController'))->toBeAnInstanceOf(FakeController::class);
            expect($controller)->toBe($this->container->get('Bandama:Test:FakeController'));
        });
    });


});
