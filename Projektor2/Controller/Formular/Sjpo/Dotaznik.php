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
class Projektor2_Controller_Formular_Sjpo_Dotaznik extends Projektor2_Controller_Formular_FlatTable {
    

    protected function createFormModels() {
        $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        $view = new Projektor2_View_HTML_Sjpo_Dotaznik($this->sessionStatus, $this->createContextFromModels(TRUE));
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $html = '<div><img src="./img/loga/logo_OPZ.png"></div>';
        $view = new Projektor2_View_HTML2PDF_Dotaznik($this->sessionStatus);
        $html .= $this->getResultFormular();

        $view->assign('html', $html);        
//        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $fileName = $this->sessionStatus->projekt->kod.'_'.'dotaznik'.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }


}

?>
