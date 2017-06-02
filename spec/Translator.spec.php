<?php

use \Bandama\Foundation\Translation\Translator;
use \Bandama\Foundation\Translation\TranslationException;


describe(Translator::class, function() {
    
    context('Initialization', function() {
        describe('::_construct', function() {
            it('exptects translations should be null when we call constructor without arguments', function() {
                $translator = new Translator();
                expect($translator->translate('hello', 'en'))->toBeNull();
                expect($translator->getTranslations())->toBeEmpty();
            });

            it('exptects translations should not be null when we call constructor with arguments', function() {
                $translator = new Translator(__DIR__.'/translations/messages.fr.php', __DIR__.'/translations/messages.en.php');
                expect($translator->getTranslations())->not->toBeEmpty();
                expect(count($translator->getTranslations()))->toBe(2);
                expect($translator->getTranslations()['fr'])->not->toBeNull();
                expect($translator->getTranslations()['en'])->not->toBeNull();
            });
        });

        describe('::addFile', function() {
            it('expects files content added to translations', function() {
                $translator = new Translator();
                $translator->addFile(__DIR__.'/translations/messages.fr.php');
                expect($translator->getTranslations())->not->toBeEmpty();
                expect(count($translator->getTranslations()))->toBe(1);
                expect($translator->getTranslations()['fr'])->not->toBeNull();

                $translator->addFile(__DIR__.'/translations/messages.en.php');
                expect(count($translator->getTranslations()))->toBe(2);
                expect($translator->getTranslations()['fr'])->not->toBeNull();
                expect($translator->getTranslations()['en'])->not->toBeNull();
            });
        });

        describe('::addData', function() {
            it('expects data to be added to translations', function() {
                $translator = new Translator();
                $fr = require(__DIR__.'/translations/messages.fr.php');
                $translator->addData($fr, 'fr');
                expect($translator->getTranslations())->not->toBeEmpty();
                expect(count($translator->getTranslations()))->toBe(1);
                expect($translator->getTranslations()['fr'])->not->toBeNull();

                $en = require(__DIR__.'/translations/messages.en.php');
                $translator->addData($en, 'en');
                expect(count($translator->getTranslations()))->toBe(2);
                expect($translator->getTranslations()['fr'])->not->toBeNull();
                expect($translator->getTranslations()['en'])->not->toBeNull();

                $enUS = require(__DIR__.'/translations/messages.en-US.php');
                $translator->addData($enUS, 'en-US');
                expect(count($translator->getTranslations()))->toBe(2);
                expect($translator->getTranslations()['en'])->toContainKey('US');
            });

            it('should throw TranslationException', function() {
                $closure = function() {
                    $translator = new Translator();
                    $en = require(__DIR__.'/translations/messages.en.php');
                    $translator->addData($en, 'en-US-ZZ');
                };

                expect($closure)->toThrow(new TranslationException('Invalid language'));
            });
        });
    });

    context('Translation', function() {
        given('translator', function() {
            return new Translator(__DIR__.'/translations/messages.fr.php', __DIR__.'/translations/messages.en.php');
        });


        describe('::translate', function() {
            it('should throw TranslationException', function() {
                $closure = function() {
                    $this->translator->translate('hello', 'en-US-ZZ');
                };

                expect($closure)->toThrow(new TranslationException('Invalid language'));
            });

            it('should return null', function() {
                expect($this->translator->translate('hell.world', 'en'))->toBeNull();
            });

            it('expects translator return "Bonjour le monde!"', function() {
                expect($this->translator->translate('hello', 'fr'))->toBe('Bonjour le monde!');
            });

            it('expects translator return "Hello world!"', function() {
                expect($this->translator->translate('hello', 'en'))->toBe('Hello world!');
            });

            it('expects translator return "Hi world!"', function() {
                $this->translator->addFile(__DIR__.'/translations/messages.en-US.php');
                expect($this->translator->translate('hello', 'en-US'))->toBe('Hi world!');
            });
        });
    });
});
