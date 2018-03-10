<?php

namespace stradivari\dic;

abstract class Container extends ABase {
    private static $containers = [];
    private $injections = [];
    private $original;
    private $injectionClass;

    final public function __construct($injectionClass = null) {
        $this->injectionClass = $injectionClass && in_array(AInjection::class, class_parents($injectionClass)) ?
            $injectionClass :
            null;
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
            if (!method_exists($injection, 'get')) {
                return null;
            }
            return $injection->get($childName);
        }
        return $injection;
    }
    final public function set($name, $injection = null) {
        if (!$injection instanceof ABase) {
            $injectionClass = $this->injectionClass;
            $injection = new $injectionClass($injection);
        } else if ($injection instanceof self) {
            $injection = $injection->cloneRecursive();
        }
        $names = explode('.', $name);
        $name = array_shift($names);
        if (!$names) {
            $this->original->injections[$name] = $injection;
            return $this;
        }
        $childName = implode('.', $names);
        if (!isset($this->original->injections[$name]) || !($this->original->injections[$name] instanceof self)) {
            $this->original->injections[$name] = $this->instantiate();
        }
        $this->original->injections[$name]->set($childName, $injection);
        return $this;
    }
    final public function delete($name) {
        $names = explode('.', $name);
        $name = array_shift($names);
        if (!$names) {
            unset($this->original->injections[$name]);
            return $this;
        }
        $childName = implode('.', $names);
        if (!isset($this->original->injections[$name]) || !($this->original->injections[$name] instanceof self)) {
            return $this;
        }
        $this->original->delete($childName);
        return $this;
    }
    final private function instantiate() {
        $class = \get_class($this);
        $obj = new $class;
        $obj->original = $obj;
        return $obj;
    }
    final private function cloneRecursive() {
        return $this->instantiate()->merge($this);
    }
    final public function merge(self $container) {
        foreach ($container->original->injections as $name => $injection) {
            $this->injections[$name] = ($injection instanceof self) ? $injection->cloneRecursive() : $injection;
        }
        return $this;
    }
}
