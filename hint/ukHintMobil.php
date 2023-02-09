
<!--autocomplete="off" vypne zobrazování historie vstupních hodnot (jsou vidět nad seznamem z datalist-->

    <label for="phone_input">Začněte psát telefonní číslo:</label>
    <input id="phone_input" list="phone_hints_list" type="text" onkeyup="showHint('phone_hints_list', 'phone', this.value)" name="<?=$prefixCizinec?>searched_phone" value="<?=$poleCizinec[$prefixCizinec.'searched_phone']?>" autocomplete="off">
    <datalist id="phone_hints_list"></datalist>
    <!--type="button" neodesílá form-->
    <button type="button" onclick="showPerson('phone_input', 'phone')">Najdi osobu z Google formuláře podle telefonu</button>
