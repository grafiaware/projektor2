<?php

/**
 * Description of TabulkaMenuOsoby
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_TabulkaMenuOsoby extends Projektor2_Controller_Abstract {

    public function getResult() {
        foreach ($this->params as $osobaMenuViewmodel) {
            $tlacitkaController = new Projektor2_Controller_Element_MenuOsoba($this->sessionStatus, $this->request, $this->response, $osobaMenuViewmodel);
            $rows[] = $tlacitkaController->getResult();
        }
        $viewZaznamy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rows, 'class'=>'zaznamy']);
        return new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$viewZaznamy, 'class'=>'content']);
    }
}
