<?php

namespace stradivari\dic;

class Injection_Pool extends Injection_Class {
    protected $objects = [];

    public function cast() {
        $params = func_get_args();
        $hash = sha1(json_encode($params));
        if (!key_exists($hash, $this->objects)) {
            $this->objects[$hash] = call_user_func_array("parent::cast", $params);
        }
        return $this->objects[$hash];
    }
}
