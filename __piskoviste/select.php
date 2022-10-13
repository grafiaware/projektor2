<?php
require '../vendor/autoload.php';

use Pes\Text\Html;

    $id = "z_up";
    $name = "z_up";
    $label = "Vysílající úřad práce:";
    $optionValues = [
        '',
        'Plzeň-město',
        'Plzeň-jih',
        'Plzeň-sever',
        'Klatovy',
        'Cheb'
    ];
    $selectedValue = 'Plzeň-sever';
    $prefix = 'cicici->';
    $context = [];



    echo Html::select($prefix.$name, $label, $optionValues, $context, ["id"=>$id, "name"=>"name z atributu", "required"=>true]);
    echo Html::select($prefix.$name, $label, $optionValues, $context, ["name"=>"name z atributu", "required"=>true]);

    $context[$prefix.$name] = 'Plzeň-sever';
    echo Html::select($prefix.$name, $label, $optionValues, $context, ["name"=>"name z atributu", "required"=>true]);

    $inputTest = $inputTest = Html::input($prefix.'titul', "Titul:", $context, ["type"=>"text", "size"=>"3", "maxlength"=>"10"]);
    $inputTest2 = Html::input($prefix.'rodne_cislo', "Rodné číslo v ČR:", $context, ["id"=>"rodne_cislo", "type"=>"text", "size"=>"20", "maxlength"=>"50", "required"=>true]);  // id pro javascript

    $fileldset = Html::tag("fieldset", [],
                    Html::tag("legend", [],  "Osobní údaje"),
                    Html::tag("p", [],
                            Html::input($prefix.'titul', "Titul:", $context, ["type"=>"text", "size"=>"3", "maxlength"=>"10"]),
                            Html::input($prefix.'jmeno', "Jméno:", $context, ["type"=>"text", "size"=>"20", "maxlength"=>"50", "required"=>true]),
                            Html::input($prefix.'prijmeni', "Příjmení:", $context, ["type"=>"text", "size"=>"20", "maxlength"=>"50", "required"=>true]),
                            Html::input($prefix.'titul_za', "Titul za:", $context, ["type"=>"text", "size"=>"3", "maxlength"=>"10"]),
                            Html::select($prefix.'pohlavi', "Pohlaví:", ["", "muž", "žena"], $context, ["id"=>"pohlavi", "required"=>true]),  // id pro javascript
                            ),
                    Html::tag("p", [],
                            Html::input($prefix.'datum_narozeni', "Datum narození:", $context, ["type"=>"text", "size"=>"8", "maxlength"=>"10"]),
                            Html::input($prefix.'rodne_cislo', "Rodné číslo v ČR:", $context, ["id"=>"rodne_cislo", "type"=>"text", "size"=>"20", "maxlength"=>"50", "required"=>true]),  // id pro javascript
                    )
                );

    echo $fileldset;