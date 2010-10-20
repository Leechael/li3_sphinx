<?php

namespace li3_sphinx\tests\cases\http;

use \Exception;
use \lithium\core\Environment;
use \li3_sphinx\http\Sphinx;

class SphinxTest extends \lithium\test\Unit {

    public function setUp () {
        Sphinx::config(array(
            'named' => array(
                'test' => array(
                    'host' => '10.0.1.2',
                    'port' => '3312'
                ),
            ),
            'default' => array(
                'test' => array(
                    'host' => '127.0.0.1',
                    'port' => '3312'
                ),
            ),
        ));
        Environment::reset();
    }

    public function testConfigIsSmoking () {
        $expected = array('test' => array('host' => '127.0.0.1', 'port' => '3312'));
        $this->assertEqual($expected, Sphinx::config('default'));
        $this->assertEqual($expected, Sphinx::config());
    }

    public function testConfigNamespace () {
        $expected = array('test' => array('host' => '10.0.1.2', 'port' => '3312'));
        $this->assertEqual($expected, Sphinx::config('named'));
    }

    public function testConfigNamespaceWithInvalidNamespace () {
        $this->assertEqual(array(), Sphinx::config('unamed'));
    }

    public function testConfigBasedOnEnvironment () {
        Environment::set('test');
        $expected = array('host' => '127.0.0.1', 'port' => '3312');
        $this->assertEqual($expected, Sphinx::config());
    }

    public function testConfigBasedOnEnvironmentWithNamespace () {
        Environment::set('test');
        $expected = array('host' => '10.0.1.2', 'port' => '3312');
        $this->assertEqual($expected, Sphinx::config('named'));
    }

    public function getInstance ($name = null) {
        Environment::set('test');
        return Sphinx::get($name);
    }

    public function testFactoryIsSmoking () {
        $result = get_class($this->getInstance());
        $this->assertEqual('SphinxClient', $result);
    }
    
}
