<?php
/**
 * Description 
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Zajemce_Registrace extends Framework_View_Abstract {
    
    /**
     * Vrací element tr
     * @return \Projektor2_View_HTML_Element_Zajemce_Registrace
     */
    public function render() {
        $zajemceRegistrace = $this->context['zajemceRegistrace'];
        
        $this->parts[]= '<tr>';
        $this->parts[]= '<td class=identifikator>' . $zajemceRegistrace->identifikator . '</td>';
        $this->parts[]= '<td class=identifikator>' . $zajemceRegistrace->znacka . '</td>';
        $this->parts[]= '<td class=jmeno>' . $zajemceRegistrace->jmeno_cele.'</td>';
        if (Config_AppContext::isVerboseMode()) {
            $this->parts[]= '<td class=jmeno>' . $zajemceRegistrace->id.'</td>';
        }           
        $this->parts[]= $this->context['htmlSkupiny']; 
        $this->parts[]= '</tr>';        
        return $this;
    }
}
