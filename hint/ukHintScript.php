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
?>

<script>
function showHint(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let dataList = document.getElementById("hints_list");
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
        xmlhttp.open("GET", "hint/getUkHint.php?q=" + str, true);
        xmlhttp.send();
    }
}

function showPerson() {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        document.getElementById("person_json").value = this.responseText;
        document.getElementById("person").innerHTML = createTable(this.responseText);
    }
    let $phoneInputElement = document.getElementById("phone_input");
    let phone = $phoneInputElement.value
    xmlhttp.open("GET", "hint/getPerson.php?phone=" + phone);
    xmlhttp.send();
}

function createTable(responseText) {
    const myObj = JSON.parse(responseText);
    let text = "<table class='hint'>"
    for (let x in myObj) {
        text += "<tr><td>" + myObj[x].header + "</td>";
        text += "<td>" + myObj[x].value + "</td></tr>";
    }
    text += "</table>"

    return text;
}
</script>


