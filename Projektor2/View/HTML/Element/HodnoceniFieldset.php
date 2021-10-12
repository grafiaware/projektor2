<?php
/**
 * Description of Projektor2_View_HTML_Element_HodnoceniFieldset
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_HodnoceniFieldset extends Framework_View_Abstract {
        
    public function render() {
            if ($this->context['readonly']) {
                $readonlyAttribute = ' readonly="readonly" ';
                $disabledAttribute = ' disabled="disabled" ';
            } else {
                $readonlyAttribute = ' ';
                $disabledAttribute = ' ';            
            }
            $this->parts[] = '<fieldset>';
            $this->parts[] = '<legend>'.$this->context['aktivita']['nadpis'].' - hodnocení</legend>';  
            // kurz fieldset je readonly
            if ($this->context['aktivita']['typ']=='kurz') {
                $view = new Projektor2_View_HTML_Element_KurzFieldset($this->sessionStatus, $this->context); 
                $view->assign('readonly', TRUE);
                $this->parts[] = $view;            
            }
            $this->parts[] = '<p>';
                $nameZnamka = $this->context['ukonceniPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$this->context['druhKurzu'].'_znamka';
                //default value je 0 
                $valueZnamka = $this->context[$nameZnamka] ? $this->context[$nameZnamka] : 0;
                $this->parts[] = '<input '
                        . 'type="number" min=0 max=5 '
                        . 'name="'.$nameZnamka.'" '
                        . 'size=1 maxlength=1 '
                        . 'value="'.$valueZnamka.'" '
                        . $disabledAttribute.'>'; 
                $this->parts[] = '<span class="help"> (zde uveďte známku hodnotící účast od 1 do 5 jako ve škole - známka je pro interní použití)</span>';
            $this->parts[] = '</p>';
            if (isset($this->context['aktivita']['s_hodnocenim']) AND $this->context['aktivita']['s_hodnocenim']) {
                $requiredAttribute = 'required="required"';
            } else {
                $requiredAttribute = '';
            }

            $nameHodnoceni = $this->context['ukonceniPrefix'].Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$this->context['druhKurzu'].'_hodnoceni';
            $this->parts[] = '<textarea '
                    . 'name="'.$nameHodnoceni.'" '
                    . 'cols=100 rows=2'
                    . $disabledAttribute.$requiredAttribute.'>'
                    . $this->context[$nameHodnoceni]
                    . '</textarea>';
            $this->parts[] = '<p class="help"> (zde uveďte slovní hodnocení účasti - pro individuální plán)'
                    . $this->context['aktivita']['help']
                    . '</p>';
            $this->parts[] ='</fieldset>   '; 
        return $this;
    }
    
}
