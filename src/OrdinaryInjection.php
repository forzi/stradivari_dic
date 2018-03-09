<?php

namespace stradivari\dic;

use ReflectionClass;

class OrdinaryInjection extends AInjection {
    protected $className;

    public function __construct($className) {
        $this->className = $className;
    }
    public function callStatic($methodName, array $params = []) {
        $className = $this->className;
        return call_user_func_array("{$className}::{$methodName}", $params);
    }
    public function cast(array $params = []) {
        $reflection = new ReflectionClass($this->className);
        return $reflection->newInstanceArgs($params);
    }
    public function isSubclassOf($name)
    {
        if ($this->className == $name) {
            return true;
        }
        if (in_array($name, class_parents($this->className))) {
            return true;
        }
        if (in_array($name, class_implements($this->className))) {
            return true;
        }
        if (in_array($name, class_uses($this->className))) {
            return true;
        }
        return false;
    }
}
