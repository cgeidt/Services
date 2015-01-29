<?php

namespace Services\Model;

use Zend\Json\Exception\InvalidArgumentException;

class ServiceThree extends Service {

    public function __construct() {
        $this->name = 'ServiceThree';
        $this->description = 'Returns the square of a number';
        $this->input = array('integer');
        $this->output = array('integer');
    }

    public function execute($params) {
        if( isset($params[0]) && is_int($params[0]) ) {
            return array($params[0] * $params[0]);
        } else {
            throw new InvalidArgumentException('Invalid Arguments (requires int*int)');
        }
    }

}
