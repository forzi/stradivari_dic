<?php

namespace stradivari\dic;

abstract class Container extends ABase {
    private static $containers = [];
    private $injections = [];
    private $original;
    private $injectionClass;

    final public function __construct($injectionClass = null) {
        $this->injectionClass = in_array(AInjection::class, class_parents($injectionClass)) ? $injectionClass : null;
        $hash = md5(static::class);
        if (!isset(self::$containers[$hash])) {
            self::$containers[$hash] = $this;
        }
        $this->original = self::$containers[$hash];
    }
    final public function get($name) {
        if (!$name) {
            return null;
        }
        $names = explode('.', $name);
        $name = array_shift($names);
        if (!isset($this->original->injections[$name])) {
            return null;
        }
        $injection = $this->original->injections[$name];
        $childName = implode('.', $names);
        if ($childName) {
            if (!$injection instanceof self) {
                return null;
            }
            return $injection->get($childName);
        }
        return $injection;
    }
    final public function set($name, $injection = null) {
        if ($injection !== null && !$injection instanceof ABase) {
            $injectionClass = $this->injectionClass;
            $injection = new $injectionClass($injection);
        } else if ($injection instanceof self) {
            $injection = $injection->cloneRecursive();
        }
        $names = explode('.', $name);
        $name = array_shift($names);
        if (!$names) {
            if ($injection === null) {
                unset($this->original->injections[$name]);
            } else {
                $this->original->injections[$name] = $injection;
            }
            return $this->original;
        }
        $childName = implode('.', $names);
        if (!isset($this->original->injections[$name]) || !($this->original->injections[$name] instanceof self)) {
            $this->original->injections[$name] = $this->cloneRecursive();
        }
        $this->original->injections[$name]->set($childName, $injection);
        return $this->original;
    }
    final private function cloneRecursive() {
        $obj = clone $this->original;
        $obj->original = $this;
        foreach ($obj->injections as $name => $injection) {
            if ($injection instanceof self) {
                $obj->injections[$name] = $obj->injections[$name]->cloneRecursive();
            }
        }
        return $obj;
    }
    final public function merge(self $container) {
        foreach ($container->original->injections as $name => $field) {
            $this->set($name, $field);
        }
    }
}
