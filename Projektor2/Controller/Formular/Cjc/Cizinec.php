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
class Projektor2_Controller_Formular_Cjc_Cizinec extends Projektor2_Controller_Formular_FlatTable {

    protected function createFormModels() {
        $this->models[Projektor2_Controller_Formular_FlatTable::CIZINEC_FT] = new Projektor2_Model_Db_Flat_ZaCizinecFlatTable($this->sessionStatus->zajemce);
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->zajemce);
    }

    protected function getResultFormular() {
        $ukHintHtml = (new Projektor2_View_HTML_Cjc_HintView($this->sessionStatus, $context))->render();
        $context = $this->createContextFromModels(TRUE);
        $fileUpload1 = (new Projektor2_View_HTML_UploadFile($this->sessionStatus, $context))->render();
        $fileUpload2 = (new Projektor2_View_HTML_UploadFile($this->sessionStatus, $context))->render();

        $view = new Projektor2_View_HTML_Cjc_Cizinec($this->sessionStatus, $context);
        $view->assign("uk_hint_fieldset", $ukHintHtml);
        $view->assign("file_upload1", $fileUpload1);
        $view->assign("file_upload2", $fileUpload2);

        $htmlResult = $view->render();
        return $htmlResult;
    }

    protected function getResultPdf() {
        $view = new Projektor2_View_PDF_Cjc_Smlouva($this->sessionStatus, $this->createContextFromModels());

        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $fileName = $this->sessionStatus->projekt->kod.'_'.'smlouva'.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
        $view->assign('file', $fileName);

        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();

        return $htmlResult;
    }

}

?>
