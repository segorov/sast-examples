<?php

echo exec('whoami');
//echo exec($_GET['cmd']);

$x = 'whoami';
//echo $_GET["asd"];

//echo `{$x} asd`;

function myexec($cmd) { echo exec($cmd); }

myfunc();

$d = new DB();
$c = new CMD();

$c->runcmd($d->getData());

// Test sink
$ex = new Extender();
$x = $d->getData();
$ex->bar($x);

class Extender {
    public function bar($data) {$this->foo($data);}
    public function foo($data) {}
}

class Base {
    public function foo($data) {echo 'foo';}
}

class Caller {
    /**
     * @var Extender
     */
    public $var;
    public function call() { $d = new DB(); $this->var->foo($d->getData()); }
}

$c = new Caller();
$c->call();
