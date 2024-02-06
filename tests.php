<?php

//include_once "CMD.php";

// 1. exec of a static function should be caught by a custom rule
echo exec('whoami'); // 1

// 2. exec of an undetermined origin possibly, should be flagged
class Request { public function getData(){return 'whoami';}}
$x = new Request();
exec($x->getData()); // 2

// 3. exec of a user controlled source should be flagged
exec($_GET['cmd']); // 3

// 4. call to a known dangerous function on a specific class should be flagged
class Danger { public function danger(){}}
$danger = new Danger();
$danger->danger(); // 4

// 5. use of backticks
echo `test`; // 5.1
$var = 'whoami'; // 5.2
echo `$var`; // 5.3

// 6. call to a child class should be flagged with a rule for the parent
class DangerChild extends Danger{}
$cdanger = new DangerChild();
$cdanger->danger(); // 6

// 7. Call to a property of a class that is well defined
class A {
    public $prop;
    public function __construct() {
        $this->prop = new Danger();
        $this->prop->danger(); // 7
    }
}
$a = new A(); //7

// 8. Call to property with no type hint
class B {
    /**
     * @var Danger
     */
    public $prop;
    public function __construct(Danger $obj) {
        $this->prop = $obj;
        $this->prop->danger(); // 8
    }

    public function call($obj) {
        $this->prop = $obj;
        $this->prop->danger(); // 9
    }

}
$b = new B(new Danger()); // 8
$b->call(new Danger()); // 9

// 10. Call to a specific dangerous function with a variable vs. a static string
function dangerexec($cmd) {echo 'danger';}
dangerexec('asdf'); // 10
//$cmd = 'asd';
dangerexec($danger->danger()); // 10


// 11. Cross-file calls
$c = new CMD();
$c->subrun($danger->danger()); // 11