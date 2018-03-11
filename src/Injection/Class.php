<?php

namespace stradivari\dic;

use ReflectionClass;

class Injection_Class extends AInjection {
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
    public function isSubclassOfInjection($name) {
        return $this->isSubclassOf($name, $this->className);
    }
    public function isInjectionSubclassOf($name) {
        return $this->isSubclassOf($this->className, $name);
    }
    protected function isSubclassOf($class1, $class2) {
        if ($class1 === $class2) {
            return true;
        }
        if (class_exists($class1) && in_array($class1, class_parents($class2))) {
            return true;
        }
        if (interface_exists($class1) && in_array($class1, class_implements($class2))) {
            return true;
        }
        if (trait_exists($class1) && in_array($class1, class_uses($class2))) {
            return true;
        }
        return false;
    }
}
