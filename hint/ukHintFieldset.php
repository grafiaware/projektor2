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
        $signCizinec = Projektor2_Controller_Formular_FlatTable::CIZINEC_FT;
        // pro jména proměnných searched_phone a person_json - mají se ukládat do flat tabulky cizinec
        $prefixCizinec = $signCizinec.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        $poleCizinec = $this->context[$signCizinec];


include "ukHintScript.php";
?>

<div>

<!--autocomplete="off" vypne zobrazování historie vstupních hodnot (jsou vidět nad seznamem z datalist-->
<fieldset><legend>Vyhledání osoby podle telefonu</legend>
<label for="phone_input">Začněte psát telefonní číslo:</label><input id="phone_input" list="hints_list" type="text" onkeyup="showHint(this.value)" name="<?=$prefixCizinec?>searched_phone" value="<?=$poleCizinec[$prefixCizinec.'searched_phone']?>" autocomplete="off">
<datalist id="hints_list"></datalist>
<input id="person_json" type="hidden" name="<?=$prefixCizinec?>person_json" value="<?=$poleCizinec[$prefixCizinec.'person_json']?>"/>
<button onclick="showPerson()" formaction="javascript:void(0);">Najdi osobu z Google formuláře</button>
<p id="person">

</p>
</fieldset>

