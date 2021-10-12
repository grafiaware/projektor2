<?php
require "../Projektor2/Date.php";

$dates[] = '2009-05-01';

$datumy[] = '1.5.2009';

$patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/');
$replace = array ('\4.\3.\1\2');

function czech_v1($patterns, $replace, $value) {
    $czech1 = preg_replace('/^0/', '\1', str_replace('.0', '.', preg_replace($patterns, $replace, $value)));
    $czech2 = str_replace('.0', '.', $czech1);    
    return $czech2;
}

function czech_v2($patterns, $replace, $value) {
    $czech1 = preg_replace($patterns, $replace, $value);
    $czech2 = preg_replace('/0(\d{1})\.(19|20)(\d{2})/', '\1.\2\3', $czech1);

    $czech3 = preg_replace('/0(\d{1})\.(\d{1,2})\.(19|20)(\d{2})/', '\1.\2.\3\4', $czech2);  
    return $czech3;
}



foreach ($dates as $ansi) {
    $ceskeDatum[] = (Projektor2_Date::createFromSqlDate($ansi))->getCzechStringDate();
    $datetime = DateTime::createFromFormat('Y-m-d', $ansi);
    $ceskeDatum2[] = $datetime->format('d.m.Y');
    $ceskeDatum3[] = $datetime->format('j.n.Y');
}


foreach ($datumy as $datum) {
    $ansiDate[] = (Projektor2_Date::createFromCzechStringDate($datum))->getSqlDate();
    $datetime = DateTime::createFromFormat('d.m.Y', $datum);
    $ansiDate2[] = $datetime->format('Y-m-d');
    $datetime = DateTime::createFromFormat('j.n.Y', $datum);
    $ansiDate3[] = $datetime->format('Y-m-d');
}
$a=1;
//^