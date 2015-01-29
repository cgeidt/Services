<?php

namespace Services\Model;

use Zend\Json\Exception\InvalidArgumentException;

class ServiceTwo extends Service {

    public function __construct() {
        $this->name = 'ServiceTwo';
        $this->description = 'Multiplies two numbers';
        $this->input = array('integer', 'integer');
        $this->output = array('integer');
    }

    public function execute($params) {
        if( isset($params[0]) && is_int($params[0]) && isset($params[1]) && is_int($params[1])) {
            return array($params[0] * $params[1]);
        } else {
            throw new InvalidArgumentException('Invalid Arguments (requires int*int)');
        }
    }
}
