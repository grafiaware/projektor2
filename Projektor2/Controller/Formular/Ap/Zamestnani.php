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
class Projektor2_Controller_Formular_Ap_Zamestnani extends Projektor2_Controller_Formular_FlatTable {
    

    protected function createFormModels() {
        //$this->flatTable = new Projektor2_Model_Flat_ZaZamFlatTable($this->sessionStatus->getUserStatus()->getZajemce()); 
        $this->models['zamestnani'] = new Projektor2_Model_Db_Flat_ZaZamFlatTable($this->sessionStatus->getUserStatus()->getZajemce()); 
    }
    
    protected function formular() {
        $htmlResult = "";
        //$pole = $this->flatTable->getValuesAssoc();
         
        $view = new Projektor2_View_HTML_Ap_Zamestnani($this->sessionStatus, $this->createContextFromModels(TRUE));
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {

        
        return ;
    }

}

?>
