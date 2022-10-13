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
class Projektor2_Controller_Formular_Sjzp_Zamestnani extends Projektor2_Controller_Formular_FlatTable {
    
    protected function createFormModels() {
        $this->models['zamestnani'] = new Projektor2_Model_Db_Flat_ZaZamFlatTable($this->sessionStatus->zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";         
        $view = new Projektor2_View_HTML_Sjzp_Zamestnani($this->sessionStatus, $this->createContextFromModels(TRUE));
        $htmlResult .= $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        return ;
    }

}

?>
