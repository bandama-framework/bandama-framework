<?php

use \Bandama\Foundation\Session\Session;
use \Bandama\Foundation\Session\SessionInterface;


describe(Session::class, function() {

    given('session', function() {
        return new Session();
    });

    it('implements SessionInterface', function() {
        expect($this->session)->toBeAnInstanceOf('\\Bandama\\Foundation\\Session\\SessionInterface');
    });

    context('session not stared', function() {
        beforeAll(function() {
            allow('session_id')->toBeCalled()->andReturn(null);
            allow('session_name')->toBeCalled()->andReturn(null);
        });

        it('not started', function() {
            expect($this->session->started())->toBeFalsy();
            expect($this->session->getId())->toBeNull();
            expect($this->session->getName())->toBeEmpty();
        });
    });

    context('session started with default parameter', function() {
        given('sessionId', function() {
            return '1234567890';
        });

        given('sessionName', function() {
            return 'BANDAMA_SESSION';
        });

        beforeAll(function() {
            allow('session_id')->toBeCalled()->andReturn($this->sessionId);
            allow('session_name')->toBeCalled()->andReturn($this->sessionName);
        });

        describe('::start()', function() {
            it('start a new session', function() {
                $this->session->start();
                expect($this->session->started())->toBeTruthy();
            });
        });

        describe('::getId()', function() {
            it('get session id', function() {
                //expect($this->session->getId())->toEqual($this->sessionId);
            });
        });

        describe('getName()', function() {
            it('get session name', function() {
                //expect($this->session->getName())->toEqual($this->sessionName);
            });
        });

        describe('::get()', function() {
            it('get if variable exists', function() {
                $_SESSION['hello'] = 'world';
                expect($this->session->get('hello'))->toEqual('world');
            });

            it('get if variable not exists', function() {
                expect($this->session->get('toto'))->toBeNull();
            });
        });

        describe('::set()', function() {
            it('define session variable', function() {
                $this->session->set('city', 'Abidjan');
                expect($this->session->get('city'))->toEqual('Abidjan');
            });

            it('remove session variable', function() {
                $this->session->set('city', 'Abidjan');
                expect($this->session->get('city'))->not->toBeNull();
                $this->session->delete('city');
                expect($this->session->get('city'))->toBeNull();
            });
        });
    });
});
