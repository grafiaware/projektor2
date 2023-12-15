<?php
/**
 * Description of
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Kurz_Fieldset extends Framework_View_Abstract {

    public function render() {
        $modelSeparator = Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        $itemSeparator = Projektor2_Controller_Formular_FlatTable::ITEM_SEPARATOR;
        $planKurzSign = Projektor2_Controller_Formular_FlatTable::PLAN_KURZ;

        $indexAktivity = $this->context['indexAktivity'];  // index aktivity
        $konfiguraceAktivity = $this->context['aktivityTypuKurz'][$indexAktivity];
        $kurzViewmodels = $this->context['kurzViewmodels'][$indexAktivity];
        /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
        $aktivitaPlan = $this->context['aktivityPlan'][$indexAktivity];
        /** @var Projektor2_Model_Db_SKurz $zvolenySKurz */
        $zvolenySKurz = $aktivitaPlan->sKurz;
        $planKurzArray = $this->context[$planKurzSign][$indexAktivity];

        // hodnoty proměnných pro vytváření atributů při skládání tagů
        if ($this->context['readonly'] ?? false) {
            // inputy jsou readonly nebo disabled a class fieldsetu pro css je "readonly"
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
            $fieldsetClass = 'readonly';
        } else {
            // inputy jsou readonly nebo disabled a class fieldsetu pro css je "noclass"
            $readonlyAttribute = ' ';
            $disabledAttribute = ' ';
            $fieldsetClass = 'noclass';
        }
        $checkedAttribute = ' checked="checked" ';

        $planKurzPrefix = 'planKurz'.$itemSeparator.$indexAktivity.$modelSeparator;

        // názvy hodnoty v contextu
        ### povinné proměnné formuláře - musí existovat a mít nastaveny neprázdné hodnoty - bez nich dojde k uložení chybných, neúplných dat do tabulky za_plan_kurz
        $nameIdSKurz = $planKurzPrefix.'id_s_kurz_FK';
        $nameKurzDruh = $planKurzPrefix.'kurz_druh_fk';
        $nameAktivita = $planKurzPrefix.'aktivita';
        ### ostatní proměnné formuláře
        $namePocAbsHodin = $planKurzPrefix.'poc_abs_hodin';
        $nameDokonceno = $planKurzPrefix.'dokonceno';
        $nameDuvodAbsence = $planKurzPrefix.'duvod_absence';
        $nameDateCertif = $planKurzPrefix.'date_certif';
        $nameDuvodNeukonceni = $planKurzPrefix.'duvod_neukonceni';

        // hodnoty z contextu
        $idSKurz = $planKurzArray[$nameIdSKurz];
        /** @var Projektor2_Viewmodel_KurzViewmodel $kurzViewmodel */
        $kurzViewmodel = $kurzViewmodels[$idSKurz];
        if ($idSKurz>3) {
            $jeZadanPocetHodin = $kurzViewmodel->jeZadanPocetHodin;
            $naplanovanKurz = true;
        } else {
            $jeZadanPocetHodin = false;
            $naplanovanKurz = false;
        }

        $zadanyAbsolvovaneHodiny = ($planKurzArray[$namePocAbsHodin] ?? null) >0 ? TRUE : FALSE;
        $zadanoUspesneNeuspesne = ($planKurzArray[$nameDokonceno] ?? null) ? TRUE : FALSE;  // hodnota je "Ano" nebo "Ne", tedy zadaná hodnote -> TRUE
        $zadanoDokoncenoAno = (($planKurzArray[$nameDokonceno] ?? null) == 'Ano') ? TRUE:FALSE;
        $zadanoDokoncenoNe = (($planKurzArray[$nameDokonceno] ?? null) == 'Ne') ? TRUE : FALSE;
        $zobrazBlokCertifikat = ($konfiguraceAktivity['s_certifikatem'] ?? null) ? TRUE : FALSE;
        $zobrazTiskniCertifikat = ($konfiguraceAktivity['certifikat']['original'] ?? null) ? TRUE : FALSE;
        $zobrazTiskniCertifikatMonitoring = ($konfiguraceAktivity['certifikat']['monitoring'] ?? null) ? TRUE : FALSE;

        $uniqueFieldsetSign = $indexAktivity;
        $idSelect = $uniqueFieldsetSign.'_select';
        $idTlacitkoAbsolvovano = $uniqueFieldsetSign.'_tlacitko_absolvovano';
        $idUdajeAbsolvovano = $uniqueFieldsetSign.'_udaje_absolvovano';

        $displayTlacitkoAbsolvovano = ($naplanovanKurz AND !$zadanyAbsolvovaneHodiny AND !$zadanoUspesneNeuspesne) ?'block':'none';
        // flag je true pokud již byl dříve zadán (načten z db) počet hodin nebo dokonceno
        $displayBlokAbsolvovano = ($zadanyAbsolvovaneHodiny OR $zadanoUspesneNeuspesne) ? 'block':'none';
            // další bloky jsou uvnitř bloku BlokAbsolvovano
            $displayBlokPocetHodin = ($jeZadanPocetHodin) ? 'block':'none';
            $displayBlokDuvodAbsence = ($planKurzArray[$nameDuvodAbsence] ?? null) ? 'block':'none';
            $displayBlokDokonceno = (!($jeZadanPocetHodin) OR $zadanoUspesneNeuspesne) ? 'block':'none';
        //blok certifikat
        $idBlokCertifikat = $uniqueFieldsetSign.'_certifikat';
        $displayBlokCertifikat = ($zadanoDokoncenoAno) ? 'block':'none';


        $modelSelect = new Projektor2_Viewmodel_Element_Select($nameIdSKurz, $kurzViewmodels, $idSKurz, $this->context['returnedModelProperty']);
        $modelSelect->setSelectId($idSelect);
        $modelSelect->setInnerTextCallable(array($this,'textRetezecKurz'));
        // $this->context['readonly'] nastyví readonly pro všechny elementy fieldsetu
        if (($this->context['readonly'] ?? false)OR $zadanyAbsolvovaneHodiny OR $zadanoUspesneNeuspesne) {
            $modelSelect->setReadonly(true);
        } else {
            $modelSelect->setOnChangeJsCode('submitForm(this);');// SUBMIT po každé změně hodnoty - je potřebný pro načtení plánovaného počtu hodin právě zvoleného kurzu
        }

        $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus, $this->context);
        $viewSelect->assign('viewModel', $modelSelect);

        ####### html ############
        $this->parts[] ='<fieldset class="'.$fieldsetClass.'">';
        $this->parts[] ='<legend>'.$konfiguraceAktivity['nadpis'].'</legend>';
        $this->parts[] ='<p>';
            $this->parts[] ='<label>'.$konfiguraceAktivity['nadpis'].': </label>';
            $this->parts[] = $viewSelect;
            $this->parts[] ='<input type="hidden" name="'.$nameKurzDruh.'" size=120 maxlength=120 value="'.$konfiguraceAktivity['kurz_druh'].'" />';
            $this->parts[] ='<input type="hidden" name="'.$nameAktivita.'" size=120 maxlength=120 value="'.$indexAktivity.'" />';
            $this->parts[] ='</p>';

        // tlačítko zadání údajů absolvováno
        if ($displayTlacitkoAbsolvovano) {
            $this->parts[] = '<input type="button" name="dummy" '
                    . 'id="'.$idTlacitkoAbsolvovano.'" style="display:'.$displayTlacitkoAbsolvovano.'" '
                    . $disabledAttribute.' value="Zadání údajů o absolvování aktivity: "';
            $this->parts[] = ' onClick="toggle(\''.$idUdajeAbsolvovano.'\');" />';
        }
        // a span absolvovano
        $this->parts[] = '<div id="'.$idUdajeAbsolvovano.'" style="display:'.$displayBlokAbsolvovano.'">';
            // span pro počet absolvovaných hodin
            $this->parts[] = '<span style="display:'.$displayBlokPocetHodin.'">';
                // počet plánovaných hodin
                $hodiny = [];
                if ($zvolenySKurz->pocet_hodin_praxe) {
                    $hodiny['Počet hodin teorie: '] = $zvolenySKurz->pocet_hodin??0;
                } else {
                    $hodiny['Počet hodin: '] = $zvolenySKurz->pocet_hodin??0;
                }
                if ($zvolenySKurz->pocet_hodin_distancne) {
                    $hodiny['Z toho distančně: '] = $zvolenySKurz->pocet_hodin??0;
                }
                if ($zvolenySKurz->pocet_hodin_praxe) {
                    $hodiny['Počet hodin praxe: '] = $zvolenySKurz->pocet_hodin_praxe??0;
                }
                $this->parts[] = '<p>';
                $this->parts[] ="<span>Plánovaný rozsah - </span>";
                foreach ($hodiny as $text => $value) {
                    $this->parts[] ="<span>$text $value</span>";
                }
                $this->parts[] = '</p>';
                $this->parts[] = '<p>';
                
                foreach ($hodiny as $text => $value) {
                    // input pro počet absolvovaných hodin - ovládá závislý prvek důvod absence
                    $this->parts[] = "<label>$text</label>";
                    $this->parts[] = '<input type="number" pattern="\d+" min="1" max="'.$value.'" '
                            . 'name="'.$namePocAbsHodin.'" '
                            . 'size=8 maxlength=10 value="'.$planKurzArray[$namePocAbsHodin].'" '
                            . $disabledAttribute
//                            . ' required'
                            . ' onChange="showWithRequiredInputsIfIn(\''.$nameDuvodAbsence.'\', this, 1, '.($value-1).');'
                            . 'showWithRequiredInputsIfGt(\''.$nameDokonceno.'\', this, 0);">';
                }
                
                $this->parts[] = '</p>';                
                // prvek důvod absence
                $this->parts[] ='<p id="'.$nameDuvodAbsence.'" style="display:'.$displayBlokDuvodAbsence.'">';
                    $this->parts[] ='<label>V případě, že neabsolvoval plný počet hodin, uveďte důvod: </label>';
                    $this->parts[] ='<input type="text" name="'.$nameDuvodAbsence.'" size=120 maxlength=120 '
                                . 'value="'.$planKurzArray[$nameDuvodAbsence].'" '
                                . $disabledAttribute.' />';                
                $this->parts[] ='</p>';
            $this->parts[] ='</span>';
            // konec span pro počet plánovaných hodin

            // input dokončeno úšpěšně/neúspěšně = 2x radio button - ovládá závislý prvek důvod neukončení
            $this->parts[] ='<p id="'.$nameDokonceno.'" style="display:'.$displayBlokDokonceno.'">';
                // první radio button
                $this->parts[] ='<label>Dokončeno úspěšně: </label>'
                    . '<input type="radio" name="'.$nameDokonceno.'" value="Ano" ';
                    if ($zadanoDokoncenoAno) {
                        $this->parts[] = $checkedAttribute;
                    } else {
                        $this->parts[] = $disabledAttribute;
                    }
                    $this->parts[] =' onClick="hideWithRequiredInputs(\''.$nameDuvodNeukonceni.'\'); show(\''.$idBlokCertifikat.'\');" />';
                // druhý radio button
                $this->parts[] ='<label>Dokončeno neúspěšně: </label>'
                        .'<input type="radio" name="'.$nameDokonceno.'" value="Ne" ';
                    if ($zadanoDokoncenoNe) {
                        $this->parts[] = $checkedAttribute;
                        $styleDuvodNeukonceni = 'block';
                    } else {
                        $this->parts[] = $disabledAttribute;
                        $styleDuvodNeukonceni = 'none';
                    }
                    $this->parts[] =' onClick="showWithRequiredInputs(\''.$nameDuvodNeukonceni.'\'); hide(\''.$idBlokCertifikat.'\');" />';
            $this->parts[] ='</p>';
            // ovládaný prvek důvod neukončení
            $this->parts[] ='<div id="'.$nameDuvodNeukonceni.'" style="display:'.$styleDuvodNeukonceni.'">'
                    . '<label>Při neúspěšném ukončení uveďte důvod: </label>'
                    . '<input type="text" name="'.$nameDuvodNeukonceni.'" size=120 maxlength=120 '
                    . 'value="'.$this->context[$nameDuvodNeukonceni].'" '
                    . $disabledAttribute.' />'
                    . '</div>';
            // konec dokončeno úšpěšně/neúspěšně a závislý prvek důvod neukončení
            // blok certifikát
            if ($zobrazBlokCertifikat) {
                $viewCertifikat = new Projektor2_View_HTML_Element_Kurz_DatumATlacitkoCertifikat($this->sessionStatus);
                $viewCertifikat->assign('readonly', $this->context['readonly']);
                $viewCertifikat->assign('idBlokCertifikat', $idBlokCertifikat);
                $viewCertifikat->assign('displayBlokCertifikat', $displayBlokCertifikat);
                $viewCertifikat->assign('zobrazTiskniCertifikat', $zobrazTiskniCertifikat);
                $viewCertifikat->assign('zobrazTiskniCertifikatMonitoring', $zobrazTiskniCertifikatMonitoring);

                $viewCertifikat->assign('planKurzPrefix', $planKurzPrefix);
                $viewCertifikat->assign('planKurzArray', $planKurzArray);
                $viewCertifikat->assign('kurzViewmodel', $kurzViewmodel);
                
                $viewCertifikat->assign('indexAktivity', $indexAktivity);
                $this->parts[] = $viewCertifikat;
            }
            // konec bloku certifikát
        $this->parts[] = '</div>';
// konec span absolvovano
        $this->parts[] ='</fieldset>';

        return $this;
    }

    /**
     * Callback funkce pro view  Projektor2_View_HTML_Element_Select.
     *
     * @param Projektor2_Viewmodel_KurzViewmodel $kurz
     * @return string
     */
    public function textRetezecKurz(Projektor2_Viewmodel_KurzViewmodel $kurz) {  // musí být public pro použití jako callback
        return $kurz->infoKurzText;
    }
}
