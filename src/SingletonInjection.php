<?php

namespace stradivari\dic;

class SingletonInjection extends OrdinaryInjection {
    protected $object;

    public function cast(array $params = []) {
        if (!$this->object) {
            $this->object = parent::cast($params);
        }
        return $this->object;
    }
}
