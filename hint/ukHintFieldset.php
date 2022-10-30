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
<fieldset><legend>Vyhledání osoby v údajích Google form</legend>

    <label for="phone_input">Začněte psát telefonní číslo:</label>
    <input id="phone_input" list="phone_hints_list" type="text" onkeyup="showHint('phone_hints_list', 'phone', this.value)" name="<?=$prefixCizinec?>searched_phone" value="<?=$poleCizinec[$prefixCizinec.'searched_phone']?>" autocomplete="off">
    <datalist id="phone_hints_list"></datalist>
    <!--type="button" neodesílá form-->
    <button type="button" onclick="showPerson('phone_input', 'phone')">Najdi osobu z Google formuláře podle telefonu</button>
<br/>
    <label for="name_input">Začněte psát příjmení:</label>
    <input id="name_input" list="name_hints_list" type="text" onkeyup="showHint('name_hints_list', 'name', this.value)" name="<?=$prefixCizinec?>searched_phone" value="<?=$poleCizinec[$prefixCizinec.'searched_phone']?>" autocomplete="off">
    <datalist id="name_hints_list"></datalist>
    <!--type="button" neodesílá form-->
    <button type="button" onclick="showPerson('name_input', 'name')">Najdi osobu z Google formuláře podle příjmení</button>

<input id="person_json" type="hidden" name="<?=$prefixCizinec?>person_json" value="<?=$poleCizinec[$prefixCizinec.'person_json']?>"/>
<p id="person">

</p>
</fieldset>

