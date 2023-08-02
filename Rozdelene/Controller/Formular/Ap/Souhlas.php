<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_Souhlas extends Projektor2_Controller_Formular_FlatTable {
    

    protected function createFormModels() {
        $this->models['smlouva'] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
    }
    
    protected function formular() {
        $htmlResult = "";
        //$pole = $this->flatTable->getValuesAssoc();
        $view = new Projektor2_View_HTML_Ap_Souhlas ($this->sessionStatus, $this->createContextFromModels(TRUE));
    
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $view = new Projektor2_View_PDF_Ap_Souhlas($this->sessionStatus, $this->createContextFromModels());
        
        $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text);
        $view->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name);
        $view->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator);
        $view->assign('znacka', $this->sessionStatus->getUserStatus()->getZajemce()->znacka);

        $fileName = $this->sessionStatus->getUserStatus()->getProjekt()->kod.'_'.'souhlas'.' '.$this->sessionStatus->getUserStatus()->getZajemce()->identifikator.'.pdf';
        $view->assign('file', $fileName);
        
        $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }

}

?>
