<?php

include __DIR__ . "/vendor/autoload.php";

use stradivari\dic\Injection_Class;
use stradivari\dic\Injection_Value;
use stradivari\dic\Injection_Callable;
use stradivari\dic\Injection_Object;
use stradivari\dic\Injection_Pool;
use stradivari\dic\Injection_Singleton;

use stradivari\dic\Container;

class Dic extends Container {}

class ExtendedDateTime extends DateTime {
    public static $extended;
}

class A extends ArrayObject {}
$obj = new A;

$dicClass       = new Dic(Injection_Class::class);
$dicSingleton   = new Dic(Injection_Singleton::class);
$dicPool        = new Dic(Injection_Pool::class);
$dicObject      = new Dic(Injection_Object::class);
$dicValue       = new Dic(Injection_Value::class);
$dicCallable    = new Dic(Injection_Callable::class);

$dicClass
    ->set('class.ArrayObject', ArrayObject::class)
    ->set('class.DateTime', ExtendedDateTime::class);

$dicSingleton
    ->set('singleton.ArrayObject', ArrayObject::class)
    ->set('singleton.DateTime', ExtendedDateTime::class);

$dicPool
    ->set('pool.ArrayObject', ArrayObject::class)
    ->set('pool.DateTime', ExtendedDateTime::class);

$dicObject
    ->set('object.ArrayObject', new ArrayObject)
    ->set('object.DateTime', new ExtendedDateTime);

$dicCallable
    ->set('sleep', 'sleep')
    ->set('var_dump', 'var_dump')
    ->set('line_n_sleep', function () {
        (new Dic)->get('var_dump')->call('---------------------');
        (new Dic)->get('sleep')->call(2);
    });

$dicValue
    ->set('number', 100500)
    ->set('text', 'ololo');

$var_dump = (new Dic)->get('var_dump');

$var_dump->call('---------------------');

$var_dump->call((new Dic)->get('text.value'));
$var_dump->call((new Dic)->get('number.value'));

$var_dump->call((new Dic)->get('object.DateTime')->getConst('ATOM'));
$var_dump->call((new Dic)->get('object.DateTime')->getStatic('extended'));
((new Dic)->get('object.DateTime')->setStatic('extended', 'some text'));
$var_dump->call((new Dic)->get('object.DateTime')->getStatic('extended'));

(new Dic)->get('var_dump')->call('---------------------');
(new Dic)->get('sleep')->call(2);

$var_dump->call((new Dic)->get('object.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('class.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('singleton.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('pool.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('singleton.DateTime')->cast('2001-01-01')->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('pool.DateTime')->cast('2001-01-01')->format("Y-m-d H:i:s"));

(new Dic)->get('line_n_sleep')->call();

$var_dump->call((new Dic)->get('object.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('class.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('singleton.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('pool.DateTime')->cast()->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('singleton.DateTime')->cast('2001-01-01')->format("Y-m-d H:i:s"));
$var_dump->call((new Dic)->get('pool.DateTime')->cast('2001-01-01')->format("Y-m-d H:i:s"));

(new Dic)->get('line_n_sleep')->call();
$var_dump->call((new Dic)->get('pool.ArrayObject')->isSubclassOfInjection(IteratorAggregate::class));
$var_dump->call((new Dic)->get('pool.ArrayObject')->isInjectionSubclassOf($obj));
$var_dump->call((new Dic)->get('pool.DateTime')->staticCallable('createFromFormat')->call('U', 0)->format("Y-m-d H:i:s"));
