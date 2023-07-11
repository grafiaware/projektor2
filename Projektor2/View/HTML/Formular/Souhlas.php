<?php
/**
 * Třída Projektor2_View_HTML_HeSouhlas zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View,
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Souhlas extends Projektor2_View_HTML_FormularPHP4 {

    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $prefixDotaznik = $signDotaznik.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $pole = $this->context[$signDotaznik];

    // nadpis je v původním kódu někde v inc - přesunout nadpisy vždy sem
    ?>
<H3>SOUHLAS SE ZPRACOVÁNÍM OSOBNICH UDAJŮ V PROJEKTU Moje budoucnost</H3>

<form method="POST" action="index.php?akce=osoby&osoby=form&form=souhlas">

<!--dále následuje původní kód-->

<FIELDSET><LEGEND style="color:white;"><b>Osobní údaje</b></LEGEND>
    <p>
  Titul: <input ID="titul" type="text" name="<?=$prefixDotaznik.'titul'?>" size="3" maxlength="10" readonly value="<?=$pole[$prefixDotaznik.'titul'];?>">
  Jméno: <input ID="jmeno" type="text" name="<?=$prefixDotaznik.'jmeno'?>" size="20" maxlength="50" readonly value="<?=$pole[$prefixDotaznik.'jmeno'];?>">
  Příjmení: <input ID="prijmeni" type="text" name="<?=$prefixDotaznik.'prijmeni'?>" size="20" maxlength="50" readonly value="<?=$pole[$prefixDotaznik.'prijmeni'];?>">
  Titul za: <input ID="titul_za" type="text" name="<?=$prefixDotaznik.'titul_za'?>" size="3" maxlength="10" readonly value="<?=$pole[$prefixDotaznik.'titul_za'];?>">
  Pohlaví: <input ID="pohlavi" type="text" name="<?=$prefixDotaznik.'pohlavi'?>" size="5" maxlength="10" readonly value="<?=$pole[$prefixDotaznik.'pohlavi'];?>">
    </p>
  <p>Datum narození: <input ID="datum_narozeni" type="date" name="<?=$prefixDotaznik.'datum_narozeni'?>" size="8" maxlength="10" readonly value="<?=$pole[$prefixDotaznik.'datum_narozeni'];?>">
    Rodné číslo: <input ID="rodne_cislo" type="text" name="<?=$prefixDotaznik.'rodne_cislo'?>" size="20" maxlength="50" readonly value="<?=$pole[$prefixDotaznik.'rodne_cislo'];?>"></p>
  <p></p>
</FIELDSET>

<FIELDSET><LEGEND style="color:white;"><b>Bydliště a kontaktní údaje</b></LEGEND>
  <FIELDSET style="border-style: solid;border-color: black; border-width: 1px;margin: 4px">
  <LEGEND style="color:black;font-size: 11px"><b>Trvalé bydliště</b></LEGEND>
  <p>Město: <input ID="mesto" type="text" name="<?=$prefixDotaznik.'mesto'?>" size="20" maxlength="50" readonly value="<?=$pole[$prefixDotaznik.'mesto'];?>">
  Ulice: <input ID="ulice" type="text" name="<?=$prefixDotaznik.'ulice'?>" size="20" maxlength="50" readonly value="<?=$pole[$prefixDotaznik.'ulice'];?>">
  PSČ: <input ID="psc" type="text" name="<?=$prefixDotaznik.'psc'?>" size="5" maxlength="5" readonly value="<?=$pole[$prefixDotaznik.'psc'];?>">
  Pevný telefon: <input ID="pevny_telefon" type="text" name="<?=$prefixDotaznik.'pevny_telefon'?>" size="15" maxlength="20" readonly value="<?=$pole[$prefixDotaznik.'pevny_telefon'];?>">
  </p>
  </FIELDSET><br>

  <FIELDSET style="border-style: solid;border-color: black; border-width: 1px;margin: 4px">
  <LEGEND style="color:black;font-size: 11px"><b>Adresa dojíždění odlišná od místa bydliště</b></LEGEND>
  <p>Město: <input ID="mesto2" type="text" name="<?=$prefixDotaznik.'mesto2'?>" size="20" maxlength="50" readonly value="<?=$pole[$prefixDotaznik.'mesto2'];?>">
  Ulice: <input ID="ulice2" type="text" name="<?=$prefixDotaznik.'ulice2'?>" size="20" maxlength="50"  readonly value="<?=$pole[$prefixDotaznik.'ulice2'];?>">
  PSČ: <input ID="psc2" type="text" name="<?=$prefixDotaznik.'psc2'?>" size="5" maxlength="5" readonly value="<?=$pole[$prefixDotaznik.'psc2'];?>">
  Pevný telefon: <input ID="pevny_telefon2" type="text" name="<?=$prefixDotaznik.'pevny_telefon2'?>" size="15" maxlength="20" readonly value="<?=$pole[$prefixDotaznik.'pevny_telefon2'];?>">
  </p>
  </FIELDSET>
  <p>Mobilní telefon: <input ID="mobilni_telefon" type="text" name="<?=$prefixDotaznik.'mobilni_telefon'?>" size="12" maxlength="15" readonly value="<?=$pole[$prefixDotaznik.'mobilni_telefon'];?>">
  Další telefony: <input ID="dalsi_telefon" type="text" name="<?=$prefixDotaznik.'dalsi_telefon'?>" size="12" maxlength="15" readonly value="<?=$pole[$prefixDotaznik.'dalsi_telefon'];?>">
  Popis: <input ID="popis_telefon" type="text" name="<?=$prefixDotaznik.'popis_telefon'?>" size="40" maxlength="100" readonly value="<?=$pole[$prefixDotaznik.'popis_telefon'];?>"></p>
  <p>e-mail: <input ID="mail" type="text" name="<?=$prefixDotaznik.'mail'?>" size="40" readonly value="<?=$pole[$prefixDotaznik.'mail'];?>"></p>
</FIELDSET>



<p>Datum vytvoření:
<input ID="datum_vytvor_smlouvy" type="date" name="<?=$prefixDotaznik.'datum_vytvor_smlouvy'?>" size="8" maxlength="10"  readonly value="<?php
                                        if ($pole[$prefixDotaznik.'datum_vytvor_smlouvy']) {echo $pole[$prefixDotaznik.'datum_vytvor_smlouvy'];}
                                        else {echo date("d.m.Y"); }
                                        ?>">
</p>

<!--<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp;
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>-->

<?php
//TISK
   if ($pole[$prefixDotaznik.'id_zajemce']){
    echo ('<p><input type="submit" value="Tisk" name="pdf">&nbsp;&nbsp;&nbsp;</p> ');    }

?>

  </form>
<?php
    }
}

?>
