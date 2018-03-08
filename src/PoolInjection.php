<?php

namespace stradivari\dic;

class PoolInjection extends OrdinaryInjection {
    protected $objects = [];

    public function cast(array $params = []) {
        $hash = sha1(json_encode($params));
        if (!key_exists($hash, $this->objects)) {
            $this->objects[$hash] = parent::cast($params);
        }
        return $this->objects[$hash];
    }
}
