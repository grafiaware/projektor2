<?php
/**
 * Description of Projektor2_Controller_Element_MenuFormulare
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuFormulare extends Projektor2_Controller_Abstract {
     
    /**
     * Očekává v poli params (předávané při volání konstruktoru) nastavenou hodootu $params['zajemceOsobniUdaje'] 
     * typu Projektor2_Model_ZajemceOsobniUdaje. Zájemce nečte z sesionStatus, protože tento kontroler je používán i pro 
     * vytvoření menu formuláře jako jednotlivých řádků ve seznamu. Pracuje tedy s zájemcem zadaných parametrem, 
     * který je jiný než zájemce v sessionStatus.
     * @return \Projektor2_View_HTML_Element_Div
     */
    public function getResult() {         
        //nové
        $htmlParts = array();
        if (isset($this->params['zajemceOsobniUdaje'])) {
            $zajemceRegistrace = Projektor2_Model_ZajemceRegistraceMapper::create($this->params['zajemceOsobniUdaje']);  
            // sada td tlačítka
            $skupinaController = new Projektor2_Controller_Element_MenuFormulare_Skupina($this->sessionStatus, $this->request, $this->response, 
                                                                 array('zajemceRegistrace'=>$zajemceRegistrace));
            $htmlSkupiny = $skupinaController->getResult();
            // tr - registrační údajr + sada tlačítek + sada signálů
            $viewRegistrace = new Projektor2_View_HTML_Element_ZajemceRegistrace($this->sessionStatus, 
                                                                 array('zajemceRegistrace'=>$zajemceRegistrace, 'htmlSkupiny'=>$htmlSkupiny));
            $htmlParts[] = $viewRegistrace;
        }
        return new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$htmlParts));
    }
}
