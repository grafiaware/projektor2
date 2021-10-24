<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

list($a, $b, $c) = [1,2];

var_dump($a);
var_dump($b);
var_dump($c);

[$a, $b, $c] = [1,2];


var_dump($a);
var_dump($b);
var_dump($c);


$e = explode(':', 'kjhk:jh');

var_dump($e);


$ar = ['a'=>'aaa'];

$elm = $ar['b'];
var_dump($elm);
$elm2 = $ar['b'] ?? null;
var_dump($elm);
$isElm = (bool) $ar['b'];
var_dump($isElm);
$isElm = (bool) ($ar['b'] ?? null);
var_dump($isElm);

