<?php

namespace stradivari\di;

class Injection_Value extends AInjection {
    protected $value;

    public function __construct($value) {
        $this->value = $value;
    }
    public function get($name = 'value') {
        if ($name == 'value') {
            return $this->value;
        }
        return null;
    }
}
