<?php

namespace Services\Model;

use Zend\Json\Exception\InvalidArgumentException;

class ServiceOne extends Service {

    static protected $name = 'ServiceOne';
    static protected $description = 'Adds two numbers';
    static protected $input = array('integer', 'integer');
    static protected $output = array('integer');

    static public function execute($params) {
        if( isset($params[0]) && is_int($params[0]) && isset($params[1]) && is_int($params[1])) {
            return array($params[0] + $params[1]);
        } else {
            throw new InvalidArgumentException('Invalid Arguments (requires int*int)');
        }
    }
}
