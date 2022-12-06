<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Navigation
 *
 * @author pes2704
 */
class Projektor2_Model_Navigation {

    private $stack;

    public function __construct() {
        $this->stack = new SplStack();
    }

    public function push(Projektor2_Model_NavigationLevel $type) {

    }

    public function pop(): ?Projektor2_Model_NavigationLevel {

    }
}
