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
class Projektor2_Controller_Formular_Cjc_Smlouva extends Projektor2_Controller_Formular_FlatTable {

    protected function createFormModels() {
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
    }

    protected function formular() {
        $htmlResult = "";
        $view = new Projektor2_View_HTML_Cjc_Smlouva($this->sessionStatus, $this->createContextFromModels(TRUE));
        $ukHintView = new Projektor2_View_HTML_Cjc_HintView($this->sessionStatus);
        $ukHintHtml = $ukHintView->render();
        $view->assign("ukHint", $ukHintHtml);
        $htmlResult .= $view->render();

        return $htmlResult;
    }

    protected function getResultPdf() {
        $view = new Projektor2_View_PDF_Cjc_Smlouva($this->sessionStatus, $this->createContextFromModels());

        $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text);
        $view->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name);
        $view->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator);

        $fileName = $this->sessionStatus->getUserStatus()->getProjekt()->kod.'_'.'smlouva'.' '.$this->sessionStatus->getUserStatus()->getZajemce()->identifikator.'.pdf';
        $view->assign('file', $fileName);

        $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();

        return $htmlResult;
    }

}

?>
