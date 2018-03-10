<?php

namespace stradivari\dic;

use ReflectionClass;

class Injection_Class extends AOopInjection {
    protected $className;

    public function __construct($className) {
        $this->className = $className;
    }
    public function staticCallable($methodName) {
        $className = $this->className;
        return new Injection_Callable("{$className}::{$methodName}");
    }
    public function cast() {
        $params = func_get_args();
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
