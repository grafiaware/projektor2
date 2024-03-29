<?php
/**
 * Description of Projektor2_Controller_Element_MenuFormulare
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuOsoba extends Projektor2_Controller_Abstract {

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
        if (isset($this->params)) {
            $osobaViewmodel = $this->params;
            // sada td tlačítka
            $skupinaController = new Projektor2_Controller_Element_MenuOsoba_Skupina($this->sessionStatus, $this->request, $this->response, $osobaViewmodel);
            $htmlSkupiny = $skupinaController->getResult();
            // tr - registrační údaje + sada tlačítek + sada signálů
            $viewRegistrace = new Projektor2_View_HTML_Element_Zajemce_Registrace($this->sessionStatus,
                                                                 array('zajemceRegistrace'=>$osobaViewmodel, 'htmlSkupiny'=>$htmlSkupiny));
            $htmlParts[] = $viewRegistrace;
        }
        return implode(PHP_EOL, $htmlParts);
    }
}
