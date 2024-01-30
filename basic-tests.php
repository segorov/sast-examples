<?php

// 1. exec of a static function should be caught by a custom rule
echo exec('whoami');

// 2. exec of an undetermined origin possibly, should be flagged
class Request { public function getData(){return 'whoami';}}
$x = new Request();
exec($x->getData());

// 3. exec of a user controlled source should be flagged
exec($_GET['cmd']);

// 4. call to a known dangerous function on a specific class should be flagged
class Danger { public function danger(){}}
$danger = new Danger();
$danger->danger();

