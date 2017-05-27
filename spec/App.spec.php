<?php

use \Bandama\App;
use \Bandama\Test;


describe(App::class, function() {

    given('app', function() {
        return App::getInstance();
    });

    beforeAll(function() {
        allow('session_id')->toBeCalled()->andReturn('1234567890');
        allow('session_start')->toBeCalled()->andReturn(true);
    });

    it('initialize and add service', function() {
        // Test unique instance
        expect($this->app)->toBe(App::getInstance());

        // Initialization Tests
        expect($this->app->getContainer())->not->toBeNull();
        expect(App::APP_MODE_PROD)->toEqual($this->app->getMode());
        expect($this->app->getConfigFile())->toBeNull();
        expect($this->app->get('config'))->not->toBeNull();
        expect($this->app->get('session'))->not->toBeNull();
        expect($this->app->get('router'))->not->toBeNull();
        expect($this->app->get('cookie'))->not->toBeNull();
        expect($this->app->get('flash'))->not->toBeNull();

        // AddService Tests
        $this->app->addService('fakeService', 'Bandama:Test:FakeService');
        $service = $this->app->get('fakeService');
        expect($service)->not->toBeNull();
        expect($service)->toBeAnInstanceOf(\Bandama\Test\FakeService::class);
        expect('Hello world')->toEqual($service->hello('world'));
    });

    it('should not cloneable', function() {
        $closure = function() {
            clone $this->app;
        };

        expect($closure)->toThrow(new Exception('Cloning is not allowed'));
    });
});
