<?php

namespace li3_sphinx\http;

use \lithium\core\Environment;

include_once dirname(__DIR__) . '/libraries/sphinxapi.php';

/**
 *
 */
class Sphinx extends \lithium\core\StaticObject {

    /**
     * @var array
     */
    protected static $_configurations = array();

    /**
     * Sets configurations for Sphinx, or returns the current configuration settings.
     *
     * @param array $config Configurations, indexed by name.
     * @return array|void Array will be returns when getting configuration.
     */
    public static function config ($config = null) {
        if ($config && is_array($config)) {
            static::$_configurations = $config;
            return;
        }
        $result = static::$_configurations;
        if (isset($config)) {
            if (!isset($result[$config])) {
                return array();
            }
            $result = $result[$config];
        } elseif (isset($result['default'])) {
            $result = $result['default'];
        }

        $cur = Environment::get();
        if (isset($result[$cur])) {
            return $result[$cur];
        }
        return $result;
    }

    public static function get ($name = null) {
        $client = new \SphinxClient();

        $config = static::config($name);
        $host = (isset($config['host'])) ? $config['host'] : 'localhost';
        $port = (int) ((isset($config['port'])) ? $config['port'] : 3312);
        $client->SetServer($host, $port);

        if (isset($config['retries'])) {
            $delay = 0;
            if (isset($config['delay'])) {
                $delay = $config['delay'];
            }
            $client->SetRetries($config['retries'], $delay);
        }

        return $client;
    }

}
