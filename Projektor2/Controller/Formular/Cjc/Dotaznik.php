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
class Projektor2_Controller_Formular_Cjc_Dotaznik extends Projektor2_Controller_Formular_Dotaznik {


    protected function createFormModels() {
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]= new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
    }

    protected function getResultFormular() {
        $htmlResult = "";
        $view = new Projektor2_View_HTML_Cjc_Dotaznik($this->sessionStatus, $this->createContextFromModels(TRUE));
        $htmlResult .= $view->render();

        return $htmlResult;
    }

    protected function getResultPdf() {
        $html = '<div></div>';
        $view = new Projektor2_View_HTML2PDF_Dotaznik($this->sessionStatus);
        $html .= $this->getResultFormular();

        $view->assign('html', $html);
//        $view->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator);

        $fileName = $this->sessionStatus->getUserStatus()->getProjekt()->kod.'_'.'dotaznik'.' '.$this->sessionStatus->getUserStatus()->getZajemce()->identifikator.'.pdf';
        $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult .= $view->getNewWindowOpenerCode();

        return $htmlResult;
    }


}

?>
