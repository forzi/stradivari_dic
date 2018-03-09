<?php

namespace stradivari\dic;

class CallableInjection extends ABase {
    protected $callable;

    public function __construct(callable $callable) {
        $this->callable = $callable;
    }
    public function call(array $params) {
        return call_user_func_array($this->callable, $params);
    }
}
