<?php

use \Bandama\Foundation\Session\Flash;
use \Bandama\Test\FakeSession;

describe(Flash::class, function() {
    given('session', function() {
        return new FakeSession();
    });

    given('flash', function() {
        return new Flash($this->session);
    });

    describe('::set', function() {
        it('should put <bandama_flash_success> key with value <Hello world> in session when no flash type is specified', function() {
            $expected = 'Hello world';
            $key = 'bandama_flash_success';
            $this->flash->set($expected);
            expect($this->session->get($key))->toEqual($expected);
            $this->session->delete($key);
        });

        it('should put <bandama_flash_warning> key with value <Be careful> in session when flash type <warning> is defined', function() {
            $expected = 'Be careful';
            $key = 'bandama_flash_warning';
            $this->flash->set($expected, 'warning');
            expect($this->session->get($key))->toEqual($expected);
            $this->session->delete($key);
        });
    });

    describe('::get', function() {
        it('should get <bandama_flash_success> key value and delete it from session variables when no flash type is specified', function() {
            $expected = 'Hello world';
            $this->flash->set($expected);
            expect($this->flash->get())->toEqual($expected);
            expect($this->flash->get())->toBeNull();
        });

        it('should get <bandama_flash_errors> key value and delete it from session variables flash type <errors> is defined', function() {
            $expected = array('Error1', 'Error2', 'Error3');
            $this->flash->set($expected, 'errors');
            expect($this->flash->get('errors'))->toBe($expected);
            expect($this->flash->get('errors'))->toBeNull();
        });
    });
});
