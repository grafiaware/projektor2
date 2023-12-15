<?php
/**
 * Description of Projektor2_View_HTML_Element_DatumATlacitkoCertifikat
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Kurz_DatumATlacitkoCertifikat extends Framework_View_Abstract {

    public function render() {
        if (isset($this->context['readonly']) AND $this->context['readonly']) {
            // inputy jsou readonly nebo disabled, inputy pro datum jsou typu text (a readonly)
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
        } else {
            // inputy nejsou readonly ani disabled, inputy pro datum jsou typu date
            $readonlyAttribute = '';
            $disabledAttribute = '';
        }
        $zobrazTiskniCertifikat = (isset($this->context['zobrazTiskniCertifikat']) AND $this->context['zobrazTiskniCertifikat']) ? TRUE : FALSE;
        $zobrazTiskniCertifikatMonitoring = (isset($this->context['zobrazTiskniCertifikatMonitoring']) AND $this->context['zobrazTiskniCertifikatMonitoring']) ? TRUE : FALSE;      
                
        $planKurzPrefix = $this->context['planKurzPrefix'];
        /** @var Projektor2_Viewmodel_KurzViewmodel $kurzViewmodel */        
        $planKurzArray = $this->context['planKurzArray'];
        /** @var Projektor2_Viewmodel_KurzViewmodel $kurzViewmodel */
        $kurzViewmodel = $this->context['kurzViewmodel'];
        $sKurz = $kurzViewmodel->sKurz;
        
        if (isset($planKurzArray[$planKurzPrefix.'date_certif']) AND $planKurzArray[$planKurzPrefix.'date_certif']) {
            $displayTiskniCertifikat = 'block';
        } else {
            $displayTiskniCertifikat = 'none';
        }
        $idTiskniCertifikat = $this->context['indexAktivity'].'_tiskni_certifikat';

        $this->parts[] = '<div id="'.$this->context['idBlokCertifikat'].'"  class="fieldsetcontainer c1c1" style="display:'.$this->context['displayBlokCertifikat'].'">';
        $this->parts[] = '<div class="leftcolumn">';
            $this->parts[] = '<p>';
            $this->parts[] = '<label>Datum pro vydání osvědčení: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.'default_'.$planKurzPrefix.'date_certif'.'" '
                    . 'value="'.$sKurz->date_zaverecna_zkouska.'" '
                    . 'disabled';
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $inputTag = '<input type="date" '
                    . 'name="'.$planKurzPrefix.'date_certif'.'" '
                    . 'value="'.$planKurzArray[$planKurzPrefix.'date_certif'].'" '
                    . $disabledAttribute.' reqired';
            if ($zobrazTiskniCertifikat) {
                $inputTag .= ' onChange="showIfNotEmpty(\''.$idTiskniCertifikat.'\', this);"';
            }
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $this->parts[] = '</p>';        
        $this->parts[] = '</div>';
        $this->parts[] = '<div class="rightcolumn">';
            $this->parts[] = '<p>';
            $this->parts[] = '<label>Datum začatku kurzu: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.'default_'.$planKurzPrefix.'date_zacatek'.'" '
                    . 'value="'.$sKurz->date_zacatek.'" '
                    . 'disabled';
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $this->parts[] = '<label>Začátek kurzu extra: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.$planKurzPrefix.'date_zacatek_extra'.'" '
                    . 'value="'.$planKurzArray[$planKurzPrefix.'date_zacatek_extra'].'" '
                    . $disabledAttribute;
            $inputTag .= ' />';
            $this->parts[] = $inputTag;        
            $this->parts[] = '</p>';
            $this->parts[] = '<p>';
            $this->parts[] = '<label>Datum konce kurzu: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.'default_'.$planKurzPrefix.'date_konec'.'" '
                    . 'value="'.$sKurz->date_konec.'" '
                    . 'disabled';
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $this->parts[] = '<label>Konec kurzu extra: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.$planKurzPrefix.'date_konec_extra'.'" '
                    . 'value="'.$planKurzArray[$planKurzPrefix.'date_konec_extra'].'" '
                    . $disabledAttribute;
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $this->parts[] = '</p>';
            $this->parts[] = '<p>';
            $this->parts[] = '<label>Datum zkousky: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.'default_'.$planKurzPrefix.'date_zaverecna_zkouska'.'" '
                    . 'value="'.$sKurz->date_zaverecna_zkouska.'" '
                    . 'disabled';
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $this->parts[] = '<label>Datum zkoušky extra: </label>';
            $inputTag = '<input type="date" '
                    . 'name="'.$planKurzPrefix.'date_zaverecna_zkouska_extra'.'" '
                    . 'value="'.$planKurzArray[$planKurzPrefix.'date_zaverecna_zkouska_extra'].'" '
                    . $disabledAttribute;        
            $inputTag .= ' />';
            $this->parts[] = $inputTag;
            $this->parts[] = '</p>';
        $this->parts[] = '</div>';


        if ($zobrazTiskniCertifikat) {
            $this->parts[] ='<p id="'.$idTiskniCertifikat.'" style="display:'.$displayTiskniCertifikat.'">';
            $this->parts[] ='<button '
                    . 'type="submit" value="Tiskni osvědčení Grafia'.$this->context['indexAktivity'].'" '
                    . 'name="pdf" '.$disabledAttribute.'>'
                    . 'Tiskni osvědčení Grafia'
                    . '</button>';
            if ($zobrazTiskniCertifikatMonitoring) {
                $this->parts[] ='<button '
                        . 'type="submit" value="Tiskni osvědčení pro monitoring '.$this->context['indexAktivity'].'" '
                        . 'name="pdf" '.$disabledAttribute.'>'
                        . 'Tiskni osvědčení pro monitoring'
                        . '</button>';
            }
            $this->parts[] ='</p> ';
        }
        $this->parts[] ='</div> ';
        return $this;
    }
}
