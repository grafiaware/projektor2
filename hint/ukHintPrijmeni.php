
<!--autocomplete="off" vypne zobrazování historie vstupních hodnot (jsou vidět nad seznamem z datalist-->

    <label for="name_input">Začněte psát příjmení:</label>
    <input id="name_input" list="name_hints_list" type="text" onkeyup="showHint('name_hints_list', 'name', this.value)" name="<?=$prefixCizinec?>searched_phone" value="<?=$poleCizinec[$prefixCizinec.'searched_phone']?>" autocomplete="off">
    <datalist id="name_hints_list"></datalist>
    <!--type="button" neodesílá form-->
    <button type="button" onclick="showPerson('name_input', 'name')">Najdi osobu z Google formuláře podle příjmení</button>


