<?php

class Test {

    public $a = 'whoami';

    public function myexec() {
        exec($this->a);
    }
}
