<?php

namespace Bandama\Test;

use \Bandama\Configuration;


class ConfigurationTest extends \PHPUnit_Framework_TestCase {

    public function testInitializationWithoutFile() {
        $config = new Configuration(null);

        $this->assertEmpty($config->getSettings());
    }

    public function testInitializationWithFile() {
        $config = new Configuration(__DIR__.'/fake-config.php');

        $this->assertArrayHasKey('appCode', $config->getSettings());
    }


    public function testGetKeyNotInSettings() {
        $config = new Configuration(__DIR__.'/fake-config.php');

        $this->assertNull($config->get('toto'));
    }

    public function testGetKeyInSettings() {
        $config = new Configuration(__DIR__.'/fake-config.php');

        $this->assertNotNull($config->get('appCode'));
    }
}
