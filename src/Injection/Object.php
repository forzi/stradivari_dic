<?php

namespace stradivari\dic;

class Injection_Object extends Injection_Singleton {
    public function __construct($object) {
        $this->object = $object;
        $this->className = get_class($object);
    }
}

