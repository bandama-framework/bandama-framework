<?php

use \Bandama\Foundation\Controller\Controller;
use \Bandama\Test\FakeControllerWithViewPath;


describe(Controller::class, function() {

    describe('::render()', function() {
        it('render without view file', function() {
            $controller = new Controller();

            ob_start();
            $controller->render('hello');
            $content = ob_get_clean();

            expect($content)->toEqual('hello');
        });

        it('render with view file', function() {
            $controller = new Controller();

            ob_start();
            $controller->render(__DIR__.'/views/home/fake-view-without-variable.php');
            $content = ob_get_clean();

            expect($content)->toEqual('Hello world');

            ob_start();
            $controller->render(__DIR__.'/views/home/fake-view-with-variable.php', array('name' => 'jf'));
            $content = ob_get_clean();

            expect($content)->toEqual('Hello jf');
        });

        it('render with view path', function() {
            $controller = new FakeControllerWithViewPath();

            $closure1 = function() use ($controller) {
                $controller->indexAction();
            };
            $closure2 = function() use ($controller) {
                $controller->helloAction('jf');
            };

            //expect($closure1)->toEcho('Hello world');
            //expect($closure2)->toEcho('Hello jf');
        });
    });

});
