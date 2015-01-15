<?php

namespace Services\Model;

class ServiceOne extends Service {

    static protected $name = 'ServiceOne';
    static protected $description = 'Adds two numbers';
    static protected $input = array('integer', 'integer');
    static protected $output = array('integer');

    static public function execute($params) {
        // execute
    }
}
