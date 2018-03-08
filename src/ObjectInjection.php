<?php

namespace stradivari\dic;

class ObjectInjection extends SingletonInjection {
    public function __construct($object) {
        $this->object = $object;
        $this->className = get_class($object);
    }
}

