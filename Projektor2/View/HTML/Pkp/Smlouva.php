<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View,
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Pkp_Smlouva extends Projektor2_View_HTML_FormularPHP4 {
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
<H3>Registrace v poradenském programu Poradenství k podnikání</H3>

<form method="POST" action="index.php?osoby=form&form=smlouva">
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
  <p><label for="datum_narozeni">Datum narození:</label><input ID="datum_narozeni" type="date" name="<?=$prefixDotaznik.'datum_narozeni'?>" size="8" maxlength="10" value="<?=$pole[$prefixDotaznik.'datum_narozeni'];?>">
  <p></p>
</FIELDSET>

<FIELDSET><LEGEND><b>Kontaktní údaje</b></LEGEND>
  <p>
  <label for="mobilni_telefon">Mobilní telefon:</label><input ID="mobilni_telefon" type="tel" name="<?=$prefixDotaznik.'mobilni_telefon'?>" size="12" maxlength="15" value="<?=$pole[$prefixDotaznik.'mobilni_telefon'];?>">
  </p>
  <p>
      <label for="mail">e-mail:</label><input ID="mail" type="email" name="<?=$prefixDotaznik.'mail'?>" size="40" value="<?=$pole[$prefixDotaznik.'mail'];?>">
  </p>
</FIELDSET>

<p>
    <label for="datum_vytvor_smlouvy">Datum vytvoření:</label>
<input ID="datum_vytvor_smlouvy" type="date" name="<?=$prefixDotaznik.'datum_vytvor_smlouvy'?>" size="8" maxlength="10" value="<?php
                                        if ($pole[$prefixDotaznik.'datum_vytvor_smlouvy']) {echo $pole[$prefixDotaznik.'datum_vytvor_smlouvy'];}
                                        else {echo date("Y-m-d"); }
                                        ?>" required>
</p>

<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp;
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>

  </form>
<?php
    }
}

?>
