<?php

namespace Services\Model;

use Zend\Json\Exception\InvalidArgumentException;

class ServiceThree extends Service {

    static protected $name = 'ServiceThree';
    static protected $description = 'Returns the square of a number';
    static protected $input = array('integer');
    static protected $output = array('integer');

    static public function execute($params) {
        if( isset($params[0]) && is_int($params[0]) ) {
            return $params[0] * $params[0];
        } else {
            throw new InvalidArgumentException('Invalid Arguments (requires int*int)');
        }
    }
}
