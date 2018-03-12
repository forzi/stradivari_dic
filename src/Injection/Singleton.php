<?php

namespace stradivari\dic;

class Injection_Singleton extends Injection_Class {
    protected $object;

    public function cast() {
        $params = func_get_args();
        if (!$this->object) {
            $this->object = call_user_func_array("parent::cast", $params);
        }
        return $this->object;
    }
}
