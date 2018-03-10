<?php

namespace stradivari\dic;

class Injection_Singleton extends Injection_Class {
    protected $object;

    public function cast(array $params = []) {
        if (!$this->object) {
            $this->object = parent::cast($params);
        }
        return $this->object;
    }
}
