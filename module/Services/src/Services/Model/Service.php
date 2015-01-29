<?php

namespace Services\Model;

abstract class Service {

    protected $name;
    protected $description;
    protected $input;
    protected $output;

    abstract public function execute($params);

    public function metadata() {
        return array(
            'name' => $this->name,
            'description' => $this->description,
            'input' => $this->input,
            'output' => $this->output,
        );
    }
}
