<?php

namespace stradivari\di;

abstract class AOopInjection extends AInjection {
    abstract public function cast(array $params = []);
    abstract public function callStatic($methodName, array $params = []);
    abstract public function isSubclassOf($name);
}
