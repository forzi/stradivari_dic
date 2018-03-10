<?php

namespace stradivari\dic;

class Injection_Pool extends Injection_Class {
    protected $objects = [];

    public function cast(array $params = []) {
        $hash = sha1(json_encode($params));
        if (!key_exists($hash, $this->objects)) {
            $this->objects[$hash] = parent::cast($params);
        }
        return $this->objects[$hash];
    }
}
