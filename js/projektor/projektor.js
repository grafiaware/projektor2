/*
 * drobné js funkce pro projektor
 */

var navratovy_objekt;
function kzam_okno(nova_url, jmeno)
{
    navratovy_objekt = document.getElementById(jmeno);
    window.open(nova_url,'Vyber_kzam');
}

var FullFileName='';
function Zobraz_pdf() {
    if (FullFileName) window.open(FullFileName);
}

function openTab(tabid) {
  var i;
  var x = document.getElementsByClassName("tab");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(tabid).style.display = "block";
}