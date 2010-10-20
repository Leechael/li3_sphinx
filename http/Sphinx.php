<?php

namespace li3_sphinx\http;

include_once dirname(__DIR__) . '/libraries/sphinxapi.php';

class Sphinx extends \lithium\core\StaticObject {

    public static function get () {
        return new \SphinxClient();
    }

}
