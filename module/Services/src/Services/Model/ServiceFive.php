<?php

namespace Services\Model;

use Zend\Json\Exception\InvalidArgumentException;

class ServiceTwo extends Service {

    public function __construct() {
        $this->name = 'ServiceFive';
        $this->description = 'Returns a random number (1...100)';
        $this->input = array();
        $this->output = array('integer');
    }

    public function execute($params) {
        return array(rand(1,100));
    }
}
