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
class Projektor2_Controller_Formular_Vdtp_Smlouva extends Projektor2_Controller_Formular_Base {

    protected function createFormModels($zajemce) {
        $this->models['smlouva'] = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }

    protected function getResultFormular() {
        $htmlResult = "";
        $view = new Projektor2_View_HTML_Vdtp_Smlouva($this->sessionStatus, $this->createContextFromModels(TRUE));
        $htmlResult .= $view->render();

        return $htmlResult;
    }

    protected function getResultPdf() {
        $view = new Projektor2_View_PDF_Pdu_Smlouva($this->sessionStatus, $this->createContextFromModels());

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
