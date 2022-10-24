<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View,
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Mb_Smlouva extends Projektor2_View_HTML_FormularPHP4 {
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $prefixDotaznik = $signDotaznik.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $pole = $this->context[$signDotaznik];
?>
<H3>SMLOUVA O ÚČASTI V PROJEKTU Moje budoucnost</H3>

<form method="POST" action="index.php?akce=osoby&osoby=form&form=sml_uc" name="<?=$prefixDotaznik.'form_sml'?>">
<FIELDSET><LEGEND><b>Osobní údaje</b></LEGEND>

    <p>
  <label for="titul">Titul:</label><input ID="titul" type="text" name="<?=$prefixDotaznik.'titul'?>" size="3" maxlength="10" value="<?=$pole[$prefixDotaznik.'titul'];?>">
  <label for="jmeno">Jméno:</label><input ID="jmeno" type="text" name="<?=$prefixDotaznik.'jmeno'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'jmeno'];?>" required>
  <label for="prijmeni">Příjmení:</label><input ID="prijmeni" type="text" name="<?=$prefixDotaznik.'prijmeni'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'prijmeni'];?>" required>
  <label for="titul_za">Titul za:</label><input ID="titul_za" type="text" name="<?=$prefixDotaznik.'titul_za'?>" size="3" maxlength="10" value="<?=$pole[$prefixDotaznik.'titul_za'];?>">
  <label for="pohlavi">Pohlaví:</label><select ID="pohlavi" size="1" name="<?=$prefixDotaznik.'pohlavi'?>" required>
          <option <?php if (@$pole[$prefixDotaznik.'pohlavi'] == ''){echo 'selected';} ?>></option>
          <option <?php if (@$pole[$prefixDotaznik.'pohlavi'] == 'muž'){echo 'selected';} ?>>muž</option>
          <option <?php if (@$pole[$prefixDotaznik.'pohlavi'] == 'žena'){echo 'selected';} ?>>žena</option>
  </select></p>
  <p><label for="datum_narozeni">Datum narození:</label><input ID="datum_narozeni" type="date" name="<?=$prefixDotaznik.'datum_narozeni'?>" size="8" maxlength="10" value="<?=$pole[$prefixDotaznik.'datum_narozeni'];?>" required>
    <label for="rodne_cislo">Rodné číslo:</label><input ID="rodne_cislo" type="text" name="<?=$prefixDotaznik.'rodne_cislo'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'rodne_cislo'];?>"></p>
  <p></p>
</FIELDSET>

<FIELDSET><LEGEND><b>Bydliště a kontaktní údaje</b></LEGEND>
  <FIELDSET>
  <LEGEND><b>Trvalé bydliště</b></LEGEND>
  <p>
  <label for="mesto">Město:</label><input ID="mesto" type="text" name="<?=$prefixDotaznik.'mesto'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'mesto'];?>" required>
  <label for="ulice">Ulice:</label><input ID="ulice" type="text" name="<?=$prefixDotaznik.'ulice'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'ulice'];?>" required>
  <label for="psc">PSČ:</label><input ID="psc" type="text" pattern="[0-9]{5}" name="<?=$prefixDotaznik.'psc'?>" size="5" maxlength="5" value="<?=$pole[$prefixDotaznik.'psc'];?>" required>
  <label for="pevny_telefon">Pevný telefon:</label><input ID="pevny_telefon" type="text" name="<?=$prefixDotaznik.'pevny_telefon'?>" size="15" maxlength="20" value="<?=$pole[$prefixDotaznik.'pevny_telefon'];?>">
  </p>
  </FIELDSET><br>
  <FIELDSET>
  <LEGEND><b>Adresa dojíždění odlišná od místa bydliště</b></LEGEND>
  <p>
  <label for="mesto2">Město:</label><input ID="mesto2" type="text" name="<?=$prefixDotaznik.'mesto2'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'mesto2'];?>">
  <label for="ulice2">Ulice:</label><input ID="ulice2" type="text" name="<?=$prefixDotaznik.'ulice2'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'ulice2'];?>">
  <label for="psc2">PSČ:</label><input ID="psc2" type="text" pattern="[0-9]{5}" name="<?=$prefixDotaznik.'psc2'?>" size="5" maxlength="5" value="<?=$pole[$prefixDotaznik.'psc2'];?>">
  <label for="pevny_telefon2">Pevný telefon:</label><input ID="pevny_telefon2" type="text" name="<?=$prefixDotaznik.'pevny_telefon2'?>" size="15" maxlength="20" value="<?=$pole[$prefixDotaznik.'pevny_telefon2'];?>">
  </p>
  </FIELDSET>
  <p>
  <label for="mobilni_telefon">Mobilní telefon:</label><input ID="mobilni_telefon" type="tel" name="<?=$prefixDotaznik.'mobilni_telefon'?>" size="12" maxlength="15" value="<?=$pole[$prefixDotaznik.'mobilni_telefon'];?>">
  <label for="dalsi_telefon">Další telefon:</label><input ID="dalsi_telefon" type="tel" name="<?=$prefixDotaznik.'dalsi_telefon'?>" size="12" maxlength="15" value="<?=$pole[$prefixDotaznik.'dalsi_telefon'];?>">
  <label for="popis_telefon">Popis:</label><input ID="popis_telefon" type="text" name="<?=$prefixDotaznik.'popis_telefon'?>" size="40" maxlength="100" value="<?=$pole[$prefixDotaznik.'popis_telefon'];?>">
  </p>
  <p>
      <label for="mail">e-mail:</label><input ID="mail" type="email" name="<?=$prefixDotaznik.'mail'?>" size="40" value="<?=$pole[$prefixDotaznik.'mail'];?>">
  </p>
</FIELDSET>


<p>
    <label for="datum_vytvor_smlouvy">Datum vytvoření:</label>
<input ID="datum_vytvor_smlouvy" type="date" name="<?=$prefixDotaznik.'datum_vytvor_smlouvy'?>" size="8" maxlength="10" value="<?php
                                        if ($pole[$prefixDotaznik.'datum_vytvor_smlouvy']) {echo $pole[$prefixDotaznik.'datum_vytvor_smlouvy'];}
                                        else {echo date("d.m.Y"); }
                                        ?>" required>
</p>

<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp;
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>
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
