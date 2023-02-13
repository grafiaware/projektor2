<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View,
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Cjc_Smlouva extends Projektor2_View_HTML_FormularPHP4 {
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $prefixDotaznik = $signDotaznik.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $pole = $this->context[$signDotaznik];
?>

<H3>SMLOUVA O ÚČASTI V PROGRAMU ČEŠTINA PRO CIZINCE</H3>
<div>
    <?= $this->context['ukHint'] ?>
</div>
<form method="POST" action="index.php?akce=osoby&osoby=form&form=cj_sml_uc" name="<?=$prefixDotaznik.'form_sml'?>">
<FIELDSET><LEGEND><b>Osobní údaje</b></LEGEND>

    <p>
  <label for="titul">Titul:</label><input id="titul" type="text" name="<?=$prefixDotaznik.'titul'?>" size="3" maxlength="10" value="<?=$pole[$prefixDotaznik.'titul'];?>">
  <label for="jmeno">Jméno:</label><input id="jmeno" type="text" name="<?=$prefixDotaznik.'jmeno'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'jmeno'];?>" required>
  <label for="prijmeni">Příjmení:</label><input id="prijmeni" type="text" name="<?=$prefixDotaznik.'prijmeni'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'prijmeni'];?>" required>
  <label for="titul_za">Titul za:</label><input id="titul_za" type="text" name="<?=$prefixDotaznik.'titul_za'?>" size="3" maxlength="10" value="<?=$pole[$prefixDotaznik.'titul_za'];?>">
  <label for="pohlavi">Pohlaví:</label><select id="pohlavi" size="1" name="<?=$prefixDotaznik.'pohlavi'?>" required>
          <option <?php if (@$pole[$prefixDotaznik.'pohlavi'] == ''){echo 'selected';} ?>></option>
          <option <?php if (@$pole[$prefixDotaznik.'pohlavi'] == 'muž'){echo 'selected';} ?>>muž</option>
          <option <?php if (@$pole[$prefixDotaznik.'pohlavi'] == 'žena'){echo 'selected';} ?>>žena</option>
  </select></p>
  <p><label for="datum_narozeni">Datum narození:</label><input id="datum_narozeni" type="date" name="<?=$prefixDotaznik.'datum_narozeni'?>" size="8" maxlength="10" value="<?=$pole[$prefixDotaznik.'datum_narozeni'];?>" required>
    <label for="rodne_cislo">Rodné číslo:</label><input id="rodne_cislo" type="text" name="<?=$prefixDotaznik.'rodne_cislo'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'rodne_cislo'];?>" readonly></p>
  <p></p>
</FIELDSET>

<FIELDSET><LEGEND><b>Bydliště a kontaktní údaje</b></LEGEND>
  <FIELDSET>
  <LEGEND><b>Bydliště v ČR</b></LEGEND>
  <p>
  <label for="mesto">Město:</label><input id="mesto" type="text" name="<?=$prefixDotaznik.'mesto'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'mesto'];?>" required>
  <label for="ulice">Ulice:</label><input id="ulice" type="text" name="<?=$prefixDotaznik.'ulice'?>" size="20" maxlength="50" value="<?=$pole[$prefixDotaznik.'ulice'];?>" required>
  <label for="psc">PSČ:</label><input id="psc" type="text" pattern="[0-9]{5}" name="<?=$prefixDotaznik.'psc'?>" size="5" maxlength="5" value="<?=$pole[$prefixDotaznik.'psc'];?>" required>
  </p>
  </FIELDSET><br>
  <FIELDSET>
  <LEGEND><b>Vhodné místo konání kurzů</b></LEGEND>
  <p>
    <label for="mesto2">Město:</label><select id="z_up" size="1" name="<?=$prefixDotaznik.'mesto2'?>" required>
          <option <?php if (@$pole[$prefixDotaznik.'mesto2'] == ''){echo 'selected';} ?>></option>
          <option <?php if (@$pole[$prefixDotaznik.'mesto2'] == 'Plzeň'){echo 'selected';} ?>>Plzeň</option>
          <option <?php if (@$pole[$prefixDotaznik.'mesto2'] == 'Klatovy'){echo 'selected';} ?>>Klatovy</option>
          <option <?php if (@$pole[$prefixDotaznik.'mesto2'] == 'Karlovy Vary'){echo 'selected';} ?>>Karlovy Vary</option>
    </select>
  </p>
  </FIELDSET>
  <FIELDSET>
      <LEGEND><b>Telefon a email</b></LEGEND>
  <p>
  <label for="mobilni_telefon">Mobilní telefon:</label><input id="mobilni_telefon" type="tel" name="<?=$prefixDotaznik.'mobilni_telefon'?>" size="12" maxlength="15" value="<?=$pole[$prefixDotaznik.'mobilni_telefon'];?>">
  <label for="dalsi_telefon">Další telefon:</label><input id="dalsi_telefon" type="tel" name="<?=$prefixDotaznik.'dalsi_telefon'?>" size="12" maxlength="15" value="<?=$pole[$prefixDotaznik.'dalsi_telefon'];?>">
  <label for="popis_telefon">Popis:</label><input id="popis_telefon" type="text" name="<?=$prefixDotaznik.'popis_telefon'?>" size="40" maxlength="100" value="<?=$pole[$prefixDotaznik.'popis_telefon'];?>">
  </p>
  <p>
      <label for="mail">e-mail:</label><input id="mail" type="email" name="<?=$prefixDotaznik.'mail'?>" size="40" value="<?=$pole[$prefixDotaznik.'mail'];?>">
  </p>
  </FIELDSET><br>
</FIELDSET>

<FIELDSET>
    <LEGEND style="color:white;"><b>Údaje zájemce</b></LEGEND>
    <p>
    <label for="z_up">Vysílající úřad práce:</label><select id="z_up" size="1" name="<?=$prefixDotaznik.'z_up'?>" required>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == ''){echo 'selected';} ?>></option>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == 'Plzeň-město'){echo 'selected';} ?>>Plzeň-město</option>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == 'Plzeň-jih'){echo 'selected';} ?>>Plzeň-jih</option>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == 'Plzeň-sever'){echo 'selected';} ?>>Plzeň-sever</option>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == 'Klatovy'){echo 'selected';} ?>>Klatovy</option>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == 'Karlovy Vary'){echo 'selected';} ?>>Karlovy Vary</option>
          <option <?php if (@$pole[$prefixDotaznik.'z_up'] == 'Cheb'){echo 'selected';} ?>>Cheb</option>
    </select>

    <label for="datum_reg">Datum registrace na ÚP:</label><input id="datum_reg" type="date" name="<?=$prefixDotaznik.'datum_reg'?>" size="8" maxlength="10" value="<?=@$pole[$prefixDotaznik.'datum_reg'];?>">
    </p><p>
    <label for="stav">Uchazeč nebo zájemce:</label><select id="stav" size="1" name="<?=$prefixDotaznik.'stav'?>" required>
          <option <?php if (@$pole[$prefixDotaznik.'stav'] == ''){echo 'selected';} ?>></option>
          <option <?php if (@$pole[$prefixDotaznik.'stav'] == 'zájemce o zaměstnání'){echo 'selected';} ?>>zájemce o zaměstnání</option>
          <option <?php if (@$pole[$prefixDotaznik.'stav'] == 'uchazeč o zaměstnání'){echo 'selected';} ?>>uchazeč o zaměstnání</option>
    </select>
    </p><p>
    <label for="datum_poradenstvi_zacatek">Datum zahájení rekvalifikace:</label><input id="datum_poradenstvi_zacatek" type="date" name="<?=$prefixDotaznik.'datum_poradenstvi_zacatek'?>" size="8" maxlength="10" value="<?=@$pole[$prefixDotaznik.'datum_poradenstvi_zacatek'];?>"></p>
    </p>
</FIELDSET>
<p>
    <label for="datum_vytvor_smlouvy">Datum vytvoření:</label><input id="datum_vytvor_smlouvy" type="date" name="<?=$prefixDotaznik.'datum_vytvor_smlouvy'?>" size="8" maxlength="10" value="<?=$pole[$prefixDotaznik.'datum_vytvor_smlouvy']?>" required>
</p>

<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp;
<input type="reset" value="Zruš provedené změny" name="B2">
</p>
<!--TISK-->
<?= $pole[$prefixDotaznik.'id_zajemce'] ? '<p><input type="submit" value="Tisk" name="pdf">&nbsp;&nbsp;&nbsp;</p> ' : ''?>
  </form>
<script>
    let dr = document.getElementById("datum_narozeni");
    let po = document.getElementById("pohlavi");
    dr.addEventListener("change", function(){
        let poValue = document.getElementById("pohlavi").value;
        let thisDate = this.valueAsDate;
        let rc = thisDate.toLocaleDateString('cx-CZ').replace(/\s+/g, '') + ' ' + (poValue=='muž' ? 'M' : (poValue=='žena' ? 'Ž' : '') );
        console.log(rc);
        document.getElementById("rodne_cislo").value=rc;
    });
    po.addEventListener("change", function(){
        let thisDate = document.getElementById("datum_narozeni").valueAsDate;
        let poValue = this.value;
        let rc = thisDate.toLocaleDateString('cx-CZ').replace(/\s+/g, '') + ' ' + (poValue=='muž' ? 'M' : (poValue=='žena' ? 'Ž' : '') );
        console.log(rc);
        document.getElementById("rodne_cislo").value=rc;
    });
</script>
<?php
    }
}

