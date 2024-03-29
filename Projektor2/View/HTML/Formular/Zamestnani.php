<?php
/**
 * Třída Projektor2_View_HTML_HeSouhlas zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View,
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_Zamestnani extends Projektor2_View_HTML_FormularPHP4 {

    /**
     * Metoda obsahuje php kod (ve stylu PHP4) kombinovaný s HTML, který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru
     * do paramentru $context metoda generuje přímo html na výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $signZamestnani = Projektor2_Controller_Formular_FlatTable::ZAM_FT;
        $prefixZamestnani = $signZamestnani.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $pole = $this->context[$signZamestnani];
        ?>
'<H3>ZÁZNAM DO EVIDENCE ZAMĚSTNAVATELŮ</H3>
<form method="POST" action="index.php?akce=osoby&osoby=form&form=zamestnani">

<FIELDSET><LEGEND>Zaměstnání</LEGEND>
<p>
  Nově vytvořené pracovní místo: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input ID="zam_nove_misto_ano" type="radio" name="<?=$prefixZamestnani.'zam_nove_misto'?>" value="Ano" <?php if ($pole[$prefixZamestnani.'zam_nove_misto'] == 'Ano') {echo 'checked';} ?>>
  Ano &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input ID="zam_nove_misto_ne" type="radio" value="Ne" name="<?=$prefixZamestnani.'zam_nove_misto'?>" <?php if ($pole[$prefixZamestnani.'zam_nove_misto'] == 'Ne') {echo 'checked';} ?>>
  Ne<br>
</p>


<p>
  Forma zaměstnání:
    <select ID="zam_forma" size="1" name="<?=$prefixZamestnani.'zam_forma'?>">
          <option <?php if ($pole[$prefixZamestnani.'zam_forma'] == '--------'){echo 'selected';} ?>>----</option>
          <option <?php if ($pole[$prefixZamestnani.'zam_forma'] == 'pracovní smlouva'){echo 'selected';} ?>>pracovní smlouva</option>
          <option <?php if ($pole[$prefixZamestnani.'zam_forma'] == 'sebezaměstnání (OSVČ)'){echo 'selected';} ?>>sebezaměstnání (OSVČ)</option>
          <option <?php if ($pole[$prefixZamestnani.'zam_forma'] == 'dohoda o provedení práce'){echo 'selected';} ?>>dohoda o provedení práce</option>
          <option <?php if ($pole[$prefixZamestnani.'zam_forma'] == 'dohoda o pracovní činnosti'){echo 'selected';} ?>>dohoda o pracovní činnosti</option>
    </select>
  </p>

<p>
  Datum nástupu do zaměstnání:
  <input ID="zam_datum_vstupu" type="date" name="<?=$prefixZamestnani.'zam_datum_vstupu'?>" size="10" maxlength="10" value="<?php echo $pole[$prefixZamestnani.'zam_datum_vstupu'];?>" required>
</p>

<FIELDSET><LEGEND><b>Údaje o zaměstnavateli</b></LEGEND>
  <p>
  Název zaměstnavatele:
  <input ID="zam_nazev" type="text" name="<?=$prefixZamestnani.'zam_nazev'?>" size="120" maxlength="255" value="<?php echo $pole[$prefixZamestnani.'zam_nazev'];?>" required>
  <br>IČ:
  <input ID="zam_ic" type="text" name="<?=$prefixZamestnani.'zam_ic'?>" size="20" maxlength="20" value="<?php echo $pole[$prefixZamestnani.'zam_ic'];?>" required>
 </p>

  <p>
  Adresa zaměstnavatele:<br>
  Město:
  <input ID="zam_mesto" type="text" name="<?=$prefixZamestnani.'zam_mesto'?>" size="30" maxlength="50" value="<?php echo $pole[$prefixZamestnani.'zam_mesto'];?>">
  Ulice:
  <input ID="zam_ulice" type="text" name="<?=$prefixZamestnani.'zam_ulice'?>" size="50" maxlength="50" value="<?php echo $pole[$prefixZamestnani.'zam_ulice'];?>">
  PSČ: <input ID="zam_psc" type="text" name="<?=$prefixZamestnani.'zam_psc'?>" size="5" maxlength="5" value="<?php echo $pole[$prefixZamestnani.'zam_psc'];?>">
  </p>

</FIELDSET>
</FIELDSET>



<FIELDSET><LEGEND>Navazující zaměstnání</LEGEND>
  <p>
  Pro případ, že forma zaměstnání je dohoda o provedení práce (DPP) nebo dohoda o pracovní činnosti (DPČ),<br>
  doplňte informace o <b>případném navazujícím pracovním poměru (na základě pracovní smlouvy) uzavřeném v návaznosti na DPP nebo DPČ</b>:<br>
  </p>
  <p>
  Datum nástupu do zaměstnání:
  <input ID="zam_navazujici_datum_vstupu" type="date" name="<?=$prefixZamestnani.'zam_navazujici_datum_vstupu'?>" size="10" maxlength="10" value="<?php echo $pole[$prefixZamestnani.'zam_navazujici_datum_vstupu'];?>">
 </p>


<FIELDSET><LEGEND><b>Údaje o zaměstnavateli</b></LEGEND>
  <p>
  Název zaměstnavatele:
  <input ID="zam_navazujici_nazev" type="text" name="<?=$prefixZamestnani.'zam_navazujici_nazev'?>" size="120" maxlength="255" value="<?php echo $pole[$prefixZamestnani.'zam_navazujici_nazev'];?>">

  <br>IČ:
  <input ID="zam_navazujici_ic" type="text" name="<?=$prefixZamestnani.'zam_navazujici_ic'?>" size="20" maxlength="20" value="<?php echo $pole[$prefixZamestnani.'zam_navazujici_ic'];?>">
 </p>

  <p>
  Adresa zaměstnavatele:<br>
  Město:
  <input ID="zam_navazujici_mesto" type="text" name="<?=$prefixZamestnani.'zam_navazujici_mesto'?>" size="30" maxlength="50" value="<?php echo $pole[$prefixZamestnani.'zam_navazujici_mesto'];?>">

  Ulice:
  <input ID="zam_navazujici_ulice" type="text" name="<?=$prefixZamestnani.'zam_navazujici_ulice'?>" size="50" maxlength="50" value="<?php echo $pole[$prefixZamestnani.'zam_navazujici_ulice'];?>">

  PSČ: <input ID="zam_navazujici_psc" type="text" name="<?=$prefixZamestnani.'zam_navazujici_psc'?>" size="5" maxlength="5" value="<?php echo $pole[$prefixZamestnani.'zam_navazujici_psc'];?>">
  </p>

</FIELDSET>
</FIELDSET>
<br> <br>




<p><input type="submit" value="Uložit" name="B1">&nbsp;&nbsp;&nbsp;
<input type="reset" value="Zruš provedené změny" name="B2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>



  </form>
<?php
    }
}

?>
