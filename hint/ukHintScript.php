<?php

/*
 * komplexní řešení
 * https://stackoverflow.com/questions/42592978/how-to-make-datalist-match-result-from-beginning-only
 */

//$start = 1;
?>

<script>
/**
 * Generuje tagy option jako potomky tagu datalist. Existující option vymaže a generuje vždy nové.
 *
 * Funkce oděšle request GET a z návratových dat tohoto dotazu generuje tagy option. Návratová data musí být string složený z hodnot oddělených čárkou.
 *
 * @param {string} datalistId ID tagu datalist
 * @param {string} type Parametr type query odesílaného na server při zavolání funkce.
 * @param {string} str Uživatelský vstup - hodnota právě vyplněná v poli input, odeslaná např. po události onChange()
 * @returns {undefined}
 */
function showHint(datalistId, type, str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";   // txtHint ??
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let dataList = document.getElementById(datalistId);
                dataList.innerHTML = "";
                const hintsArray = this.responseText.split(",");
                hintsArray.forEach(function(item) {
                  // Create a new <option> element.
                  var option = document.createElement('option');
                  option.value = item;
                  dataList.appendChild(option);
                });
            }
        };
        xmlhttp.open("GET", "hint/getUkHint.php?type=" + type + "&q=" + str, true);
        xmlhttp.send();
    }
}

/**
 * Odešle request pro získání dat o osobě ve formátu json.
 * Získaná data uloží do elementu s id "person_json" (obvykle hidden input pro odeslání a uložení json dat na serveru, např v db),
 * dále vygeneruje HTML table ze získaných dat a vloží element table do elementu s id "person" (pro zobrazení dat ve formě HTML tabulky).
 *
 * @param {type} inputElementId
 * @param {type} type
 * @returns {undefined}
 */
function showPerson(inputElementId, type) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        document.getElementById("person_json").value = this.responseText;
        document.getElementById("person").innerHTML = createTable(this.responseText);
    }
    let inputElement = document.getElementById(inputElementId);
    let inputValue = inputElement.value
    xmlhttp.open("GET", "hint/getPerson.php?" + type + "=" + inputValue);
    xmlhttp.send();
}

function createTable(responseText) {
    const myObj = JSON.parse(responseText);
    let text = "<table class='hint'>"
    for (let x in myObj) {
        text += "<tr>";
        text += "<td>" + myObj[x].header + "</td>";
        text += "<td>" + myObj[x].value + "</td>";
        text += "</tr>";
    }
    text += "</table>"

    return text;
}
</script>


