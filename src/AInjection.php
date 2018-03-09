<?php

namespace stradivari\dic;

abstract class AInjection extends ABase {
    abstract public function cast(array $params = []);
    abstract public function callStatic($methodName, array $params = []);
    abstract public function isSubclassOf($name);
}
