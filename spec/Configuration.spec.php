<?php

use \Bandama\Configuration;


describe(Configuration::class, function() {

    describe('::__construct()', function() {
        it('initializes without file', function() {
            $config = new Configuration();

            expect($config->getSettings())->toBeEmpty();
        });

        it('initializes with file', function() {
            $config = new Configuration(__DIR__.'/config/fake-config.php');

            expect($config->getSettings())->toContainKey('appCode');
        });
    });

    describe('::get()', function() {
        given('config', function() {
            return new Configuration(__DIR__.'/config/fake-config.php');
        });

        it('should return null', function() {
            expect($this->config->get('toto'))->toBeNull();
        });

        it('return [bandama-framework]', function() {
            expect($this->config->get('appCode'))->not->toBeNull();
            expect($this->config->get('appCode'))->toEqual('bandama-framework');
        });
    });

});
