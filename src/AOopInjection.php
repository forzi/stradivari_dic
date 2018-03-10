<?php

namespace stradivari\dic;

abstract class AOopInjection extends AInjection {
    abstract public function cast();
    abstract public function staticCallable($methodName);
    abstract public function isSubclassOf($name);
}
