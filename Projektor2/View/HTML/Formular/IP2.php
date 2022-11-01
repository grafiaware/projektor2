<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_IP2 extends Framework_View_Abstract {

    public function render() {
        $signUkonceni = Projektor2_Controller_Formular_FlatTable::UKONC_FT;
        $prefixUkonceni = $signUkonceni.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $requiredAttribute = ' required="required" ';
        $checkedAttribute = ' checked="checked" ';

        $nameDokonceno = $prefixUkonceni.'dokonceno';
        $zadanoDokoncenoAno = ($this->context[$signUkonceni][$nameDokonceno] == 'Ano');
        $zadanoDokoncenoNe = ($this->context[$signUkonceni][$nameDokonceno] == 'Ne');
        $nameDatumCertif = $prefixUkonceni.'datum_certif';
        $nameDatumUkonceni = $prefixUkonceni.'datum_ukonceni';
        $idBlokDuvod = 'idDuvodSelect';
        $displayBlokDuvod = ($this->context[$signUkonceni][$nameDatumUkonceni]) ? 'block' : 'none';
        $zobrazBlokUspesneNeuspesnePodporenySCertifikatem = $this->context['aktivitaProjektu']['s_certifikatem'];
        $idBlokHodnoceni = 'idBlokHodnoceni';
        // blok úspěšně/neúspěšně se zobrazuje pokud je zadáno dokončeno (buď ano nebo ne)
        if ($zadanoDokoncenoAno OR $zadanoDokoncenoNe) {
            $displayBlokHodnoceni = 'block';
            $disabledAttributeDatumADuvod = ' disabled="disabled" ';
            $disabledDuvod = TRUE;
        } else {
            $displayBlokHodnoceni = 'none';
            $disabledAttributeDatumADuvod = '';
            $disabledDuvod = FALSE;
        }

        $this->parts[] = '<div>';
        $this->parts[] = '<H3>'.$this->context['nadpis'].'</H3>';
        $this->parts[] = '<form method="POST" action="index.php?osoby=form&form='.$this->context['formAction'].'" name="form_ukonc">';

            $this->parts[] = '<fieldset>';
            $this->parts[] = '<legend>Ukončení účasti v projektu</legend>';
                // fieladset datum a důvod ukončení účasti
                $this->parts[] = '<fieldset>';
                $this->parts[] = '<legend>Datum a důvod ukončení účasti</legend>';
                    $this->parts[] = '<p>Datum ukončení účasti v projektu:';
                        $this->parts[] = '<input '
                            . 'type="date" name="'.$nameDatumUkonceni.'" '
                            . 'size="10" maxlength="10" '
                            . 'value="'.$this->context[$signUkonceni][$nameDatumUkonceni].'" '
                            . $requiredAttribute
                            . $disabledAttributeDatumADuvod
                            . 'onChange="showIfNotEmpty(\''.$idBlokDuvod.'\', this);" >';
                    $this->parts[] = '</p>';
                    // span důvod
                    $this->parts[] = '<span id="'.$idBlokDuvod.'" style="display:'.$displayBlokDuvod.'">';
                        $this->parts[] = '<p>Důvod ukončení účasti v projektu:';
//                            $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus, $this->context);
                            $name = $prefixUkonceni.'duvod_ukonceni';
//                            $viewSelect->assign('selectId', 'ukonceni')
//                                    ->assign('selectName', $name)
//                                    ->assign('valuesArray', $this->context['duvodUkonceniValuesArray'])
//                                    ->assign('actualValue', $this->context[$name])
//                                    ->assign('disabled', $disabledDuvod)
//                                    ->assign('required', TRUE);  //funkční jen pro prázdnou hodnotu v prvním option

        $modelSelect = new Projektor2_Viewmodel_Element_Select($name, $this->context['duvodUkonceniValuesArray'], $this->context[$signUkonceni][$name]);
        $modelSelect->setSelectId('ukonceni');
        $modelSelect->setDisabled(false);
        $modelSelect->setRequired(true);
        $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus);
        $viewSelect->assign('viewModel', $modelSelect);

                            $this->parts[] = $viewSelect;
                        $this->parts[] ='</p>';

                        $this->parts[] = '<p>Podrobnější popis důvodu ukončení - vyplňujte pouze v případech 2b, 3a a 3b:</p>';
                        $this->parts[] = '<p>';
                            $this->parts[] = '<input'
                                    . ' ID="popis_ukonceni"'
                                    . ' type="text" name="'.$prefixUkonceni.'popis_ukonceni"'
                                    . ' size="120"'
                                    . ' maxlength="120"'
                                    . ' value="'.$this->context[$signUkonceni][$prefixUkonceni.'popis_ukonceni'].'"'
                                    . $disabledAttributeDatumADuvod
                                    . '>';
                        $this->parts[] = '</p>';
                        $this->parts[] = '<span class="help">Ukončení účasti účastníka v projektu může nastat:<br>';
                            foreach ($this->context['duvodUkonceniHelpArray'] as $helpTextRow) {
                                $this->parts[] = '<p>'.$helpTextRow.'</p>';
                            }
                        $this->parts[] = '</span>';
                    $this->parts[] = '</span>';// konec span důvod
                $this->parts[] ='</fieldset>';
                // blok uspesne/neuspesne podporeny
                $this->parts[] ='<fieldset>';
                    if ($zobrazBlokUspesneNeuspesnePodporenySCertifikatem) {
                        $onClickDokoncenoAno = ' onClick="show(\'idBlokCertifikat\');show(\''.$idBlokHodnoceni.'\');">';
                        $onClickDokoncenoNe = ' onClick="hide(\'idBlokCertifikat\');show(\''.$idBlokHodnoceni.'\');">';
                        // certifikat
                        $viewCertifikat = new Projektor2_View_HTML_Element_Kurz_DatumATlacitkoCertifikat($this->sessionStatus);
                        if (isset($this->context['readonly'])) {
                            $viewCertifikat->assign('readonly', $this->context['readonly']);
                        }
                        $viewCertifikat->assign('idBlokCertifikat', 'idBlokCertifikat');
                        $viewCertifikat->assign('nameDatumCertif', $nameDatumCertif);
                        $viewCertifikat->assign('valueDatumCertif', $this->context[$signUkonceni][$nameDatumCertif]);
                        $viewCertifikat->assign('druhKurzu', 'projekt');
                        if ($zadanoDokoncenoAno) {
                            $viewCertifikat->assign('displayBlokCertifikat', 'block');
                        } else {
                            $viewCertifikat->assign('displayBlokCertifikat', 'none');
                        }
                        // projektový certifikát se z projektoru tiskne vždy
                        $viewCertifikat->assign('zobrazTiskniCertifikat', TRUE);
                    } else {
                        $onClickDokoncenoAno = ' onClick="show(\''.$idBlokHodnoceni.'\');">';
                        $onClickDokoncenoNe = ' onClick="show(\''.$idBlokHodnoceni.'\');">';
                    }
                    $this->parts[] = '<legend>Úspěšnost a certifikát</legend>';
                    $this->parts[] ='<label for="'.$nameDokonceno.'-ano" >Úspěšně podpořená osoba: </label>'
                            . '<input type="radio" '
                            . 'id="'.$nameDokonceno.'-ano" '
                            . 'name="'.$nameDokonceno.'" '
                            . 'value="Ano" '
                            . ($zadanoDokoncenoAno ? $checkedAttribute : '')
                            . $requiredAttribute
                            . $onClickDokoncenoAno;
                    $this->parts[] ='<label for="'.$nameDokonceno.'-ne" >Neúspěšně podpořená osoba: </label>'
                            .'<input type="radio" '
                            . 'id="'.$nameDokonceno.'-ne" '
                            . 'name="'.$nameDokonceno.'" '
                            . 'value="Ne" '
                            . ($zadanoDokoncenoNe ? $checkedAttribute : '')
                            . $requiredAttribute
                            . $onClickDokoncenoNe;
                    if (isset($viewCertifikat)) {
                        $this->parts[] = $viewCertifikat;
                    }
                $this->parts[] ='</fieldset>';

                // blok hodnocení
                $this->parts[] = '<span id="'.$idBlokHodnoceni.'" style="display:'.$displayBlokHodnoceni.'">';
                    // hodnocení kurzy
                    $kurzyPlan = $this->context['aktivityPlan'];
                    if (isset($this->context['modelyKurzu']) AND $this->context['modelyKurzu']) {
                        foreach (array_keys($this->context['aktivityKurz']) as $aktivita) {  // používám jen klíče - pole aktivit je v context
                            $view = new Projektor2_View_HTML_Element_Aktivita_HodnoceniFieldset($this->sessionStatus, $this->context);
                            $view
                                ->assign('aktivita', $aktivita)
                                ->assign('ukonceniPrefix', Projektor2_Controller_Formular_FlatTable::UKONC_FT)
                                ->assign('readonly', FALSE);  // pro hodnocení, kurzy fieldset jsou readonly
                            $this->parts[] = $view;
                        }
//                        foreach ($this->context['kurzyModels'] as $druhKurzu=>$sKurzyJednohoDruhu) {
//                            $view = new Projektor2_View_HTML_Element_HodnoceniFieldset($this->sessionStatus, $this->context);
//                            $view->assign('planPrefix', Projektor2_Controller_Formular_Base::PLAN_KURZ)
//                                ->assign('ukonceniPrefix', Projektor2_Controller_Formular_Base::UKONC_FT)
//                                ->assign('druhKurzu', $druhKurzu)
//                                ->assign('modelsArray', $sKurzyJednohoDruhu)
//                                ->assign('returnedModelProperty', 'id')
//                                ->assign('aktivitaProjektu', $this->context['aktivityProjektuTypuKurz'][$druhKurzu])
//                                ->assign('kurzPlan', $kurzyPlan[$druhKurzu])
//                                ->assign('readonly', FALSE);
//                            $this->parts[] = $view;
//                        }
                    }
                    // hodnocení poradenství
                    if (isset($this->context['aktivityProjektuTypuPoradenstvi']) AND $this->context['aktivityProjektuTypuPoradenstvi']) {
                        foreach ($this->context['aktivityProjektuTypuPoradenstvi'] as $druhKurzu => $aktivita) {
                            $view = new Projektor2_View_HTML_Element_Aktivita_HodnoceniFieldset($this->sessionStatus, $this->context);
                            $view->assign('planPrefix', Projektor2_Controller_Formular_FlatTable::PLAN_KURZ)
                                ->assign('ukonceniPrefix', Projektor2_Controller_Formular_FlatTable::UKONC_FT)
                                ->assign('druhKurzu', $druhKurzu)
                                ->assign('modelsArray', $sKurzyJednohoDruhu)
                                ->assign('returnedModelProperty', 'id')
                                ->assign('aktivitaProjektu', $this->context['aktivityProjektuTypuKurz'][$druhKurzu])
                                ->assign('kurzPlan', $kurzyPlan[$druhKurzu])
                                ->assign('readonly', FALSE);
                            $this->parts[] = $view;
                        }
                    }
                    // Příloha
                    $this->parts[] ='<fieldset>';
                    $this->parts[] = '<legend>Příloha</legend>';
                        $this->parts[] = '<p>V případě, že nebylo možné získat podpis účastníka, uveďte zde důvod:</p>';
                        $this->parts[] = '<p>';
                            $this->parts[] = '<input ID="neni_podpis" type="text" name="'.$prefixUkonceni.'neni_podpis" size="120" maxlength="120" value="'.$this->context[$signUkonceni][$prefixUkonceni.'neni_podpis'].'">';
                        $this->parts[] = '</p>';
                        $this->parts[] = '<p>Příloha:';
                            $this->parts[] = '<input ID="priloha" type="text" name="'.$prefixUkonceni.'priloha" size="120" maxlength="120" value="'.$this->context[$signUkonceni][$prefixUkonceni.'priloha'].'"> (zde uveďte typ přílohy)';
                        $this->parts[] = '</p>';
                $this->parts[] = '</span>';
                $this->parts[] = '</span>';
            $this->parts[] = '</fieldset>';
            // datumy
            $this->parts[] = '<p>Datum vytvoření:';
                $this->parts[] = '<input ID="datum_vytvor_dok" type="date" name="'.$prefixUkonceni.'datum_vytvor_dok_ukonc" size="8" maxlength="10" value="'
                        .$this->context[$signUkonceni][$prefixUkonceni.'datum_vytvor_dok_ukonc'].'" required >';
            $this->parts[] = '</p>';
            // submit
            $this->parts[] = '<p>';
                $this->parts[] = isset($this->context['submitUloz']) ? '<input type="submit" value="'.$this->context['submitUloz']['value'].'" name="'.$this->context['submitUloz']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
                $this->parts[] = '<input type="reset" value="Zruš provedené změny" name="dummy">';
            $this->parts[] = '</p>';
            if ($this->context[$signUkonceni][$prefixUkonceni.'id_zajemce']){
                $this->parts[] = isset($this->context['submitTiskIP2']) ? '<p><input type="submit" value="'.$this->context['submitTiskIP2']['value'].'" name="'.$this->context['submitTiskIP2']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
                $this->parts[] = isset($this->context['submitTiskIP2Hodnoceni']) ? '<p><input type="submit" value="'.$this->context['submitTiskIP2Hodnoceni']['value'].'" name="'.$this->context['submitTiskIP2Hodnoceni']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
                $this->parts[] = isset($this->context['submitTiskUkonceni']) ? '<p><input type="submit" value="'.$this->context['submitTiskUkonceni']['value'].'" name="'.$this->context['submitTiskUkonceni']['name'].'">&nbsp;&nbsp;&nbsp;</p> ' : '';
            }
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';
        return $this;
    }
}

