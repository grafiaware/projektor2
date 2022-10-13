<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/*
 * komplexní řešení
 * https://stackoverflow.com/questions/42592978/how-to-make-datalist-match-result-from-beginning-only
 */

//$start = 1;

include "ukHintScript.php";
?>

<div>

<!--autocomplete="off" vypne zobrazování historie vstupních hodnot (jsou vidět nad seznamem z datalist-->
<form method="GET" autocomplete="off"  action="javascript:void(0);">
<fieldset><legend><b>Vyhledání osoby podle telefonu</b></legend>
<label for="phone_input">Začněte psát telefonní číslo:</label><input id="phone_input" list="hints_list" type="text" onkeyup="showHint(this.value)" name="phone">
<datalist id="hints_list"></datalist>
<button onclick="showPerson()">Najdi osobu</button>
<input id="registration_json" type="hidden" name="registration_json"/>
</fieldset>
</form>
<div id="person"></div>

</div>

