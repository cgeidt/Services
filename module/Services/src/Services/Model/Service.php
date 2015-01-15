<?php

namespace Services\Model;

abstract class Service {
    static protected $name;
    static protected $description;
    static protected $input;
    static protected $output;
    abstract static public function execute($params);

    static public function getMetadata() {
        json_encode(
            array(
                'name' => self::$name,
                'description' => self::description,
                'input' => self::input,
                'output' => self::output,
            )
        );
    }
}
