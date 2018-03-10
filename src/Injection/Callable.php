<?php

namespace stradivari\dic;

class Injection_Callable extends AInjection {
    protected $callable;

    public function __construct(callable $callable) {
        $this->callable = $callable;
    }
    public function call() {
        $params = func_get_args();
        return call_user_func_array($this->callable, $params);
    }
}
