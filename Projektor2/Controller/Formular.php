<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular extends Projektor2_Controller_Abstract {

    protected function getLeftMenuArray() {
        return $this->getLeftMenuArrayUni();
    }

    private function getLeftMenuArrayUni() {
        $menuArray[] = array('href'=>'index.php?akce=zobraz_reg', 'text'=>'Zpět na výběr zájemce');
        return $menuArray;
    }

    public function getResult() {

        $gridParts[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, array('menuArray'=>$this->getLeftMenuArray()));

        // nezobrazuje se pro novou osobu
        if ($this->sessionStatus->zajemce) {
            $zajemceRegistrace = Projektor2_Viewmodel_ZajemceRegistraceMapper::findById($this->sessionStatus->zajemce->id);
                $tlacitkaController = new Projektor2_Controller_Element_MenuZajemce($this->sessionStatus, $this->request, $this->response, $zajemceRegistrace);
                $rows[] = $tlacitkaController->getResult();
            $contentParts[] = new Projektor2_View_HTML_Element_Table($this->sessionStatus, array('rows'=>$rows, 'class'=>'zaznamy'));
        }
        $router = new Projektor2_Router_Form($this->sessionStatus, $this->request, $this->response);
        $formController = $router->getController();
        $contentParts[] = $formController->getResult();
        $gridParts[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$contentParts, 'class'=>'content'));

        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$gridParts, 'class'=>'grid-container'));
        return $viewZobrazeniRegistraci;
    }
}

