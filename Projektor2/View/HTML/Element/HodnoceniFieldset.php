<?php
/**
 * Description of Projektor2_View_HTML_Element_HodnoceniFieldset
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_HodnoceniFieldset extends Framework_View_Abstract {

    public function render() {
        $modelSeparator = Projektor2_Controller_Formular_Base::MODEL_SEPARATOR;
        $itemSeparator = Projektor2_Controller_Formular_Base::ITEM_SEPARATOR;
        $planKurzSign = Projektor2_Controller_Formular_Base::PLAN_KURZ;

        $aktivita = $this->context['aktivita'];
        $parametryAktivity = $this->context['aktivityKurz'][$aktivita];
        $modelyKurzu = $this->context['modelyKurzu'][$aktivita];
        $planKurzArray = $this->context[$planKurzSign][$aktivita];

        $signUkonceni = Projektor2_Controller_Formular_Base::UKONC_FT;
        $prefixUkonceni = $signUkonceni.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR;

        if ($this->context['readonly']) {
            $readonlyAttribute = ' readonly="readonly" ';
            $disabledAttribute = ' disabled="disabled" ';
        } else {
            $readonlyAttribute = ' ';
            $disabledAttribute = ' ';
        }
        $this->parts[] = '<fieldset>';
        $this->parts[] ='<legend>'.$parametryAktivity['nadpis'].' - hodnocení</legend>';
        // kurz fieldset je readonly
        if ($parametryAktivity['typ']=='kurz') {
            $view = new Projektor2_View_HTML_Element_KurzFieldset($this->sessionStatus, $this->context);
            $view->assign('returnedModelProperty', 'id');
            $view->assign('readonly', TRUE);
            $this->parts[] = $view;
        }

        if (isset($parametryAktivity['s_hodnocenim']) AND $parametryAktivity['s_hodnocenim']) {
            $this->parts[] = '<p>';
                $nameZnamka = $prefixUkonceni.$aktivita.'_znamka';
                //default value je 0
                $valueZnamka = $this->context[$signUkonceni][$nameZnamka] ?? 0;
                $this->parts[] = '<input '
                        . 'type="number" min=0 max=5 '
                        . 'name="'.$nameZnamka.'" '
                        . 'size=1 maxlength=1 '
                        . 'value="'.$valueZnamka.'" '
                        . $disabledAttribute.'>';
                $this->parts[] = '<span class="help"> (zde uveďte známku hodnotící účast od 1 do 5 jako ve škole - známka je pro interní použití)</span>';
            $this->parts[] = '</p>';

            $nameHodnoceni = $prefixUkonceni.$aktivita.'_hodnoceni';
            $this->parts[] = '<textarea '
                    . 'name="'.$nameHodnoceni.'" '
                    . 'cols=100 rows=2'
                    . $disabledAttribute.'required="required"'.'>'
                    . $this->context[$signUkonceni][$nameHodnoceni]
                    . '</textarea>';
            $this->parts[] = '<p class="help"> (zde uveďte slovní hodnocení účasti - pro individuální plán)'
                    . $this->context['aktivitaProjektu']['help']
                    . '</p>';
        }
        $this->parts[] ='</fieldset>   ';
        return $this;
    }

}
