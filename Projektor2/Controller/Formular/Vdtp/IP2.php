<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Vdtp_IP2 extends Projektor2_Controller_Formular_IP {

    protected function createFormModels() {
        $this->models['ukonceni'] = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
        $this->models['plan']= new Projektor2_Model_Db_Flat_ZaPlanFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
        $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
    }

    protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Config_Aktivity::findAktivity($this->sessionStatus->getUserStatus()->getProjekt()->kod, Config_Aktivity::TYP_KURZ);
        $kurzyModelsAssoc = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);
        $kurzyPlanAssoc = Projektor2_Viewmodel_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->getUserStatus()->getZajemce());

        $ukonceniArray = Config_Ukonceni::getUkonceniProjektu($this->sessionStatus->getUserStatus()->getProjekt()->kod);

        $view = new Projektor2_View_HTML_Formular_IP2($this->sessionStatus, $this->createContextFromModels(TRUE));
        $view->assign('nadpis', 'UKONČENÍ ÚČASTI V PROJEKTU A DOPLNĚNÍ IP - 2. část')
            ->assign('formAction', 'ukonceni')
            ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)
            ->assign('duvodUkonceniValuesArray', $ukonceniArray['duvod'])
            ->assign('duvodUkonceniHelpArray', $ukonceniArray['duvodHelp'])
            ->assign('s_certifikatem', $ukonceniArray['s_certifikatem'])
            ->assign('kurzyModels', $kurzyModelsAssoc)
            ->assign('aktivityPlan', $kurzyPlanAssoc)
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))
            ->assign('submitTiskIP2', array('name'=>'pdf', 'value'=>'Tiskni IP 2.část - vyhodnocení aktivit'))
            ->assign('submitTiskUkonceni', array('name'=>'pdf', 'value'=>'Tiskni ukončení účasti'));
        return $view;
    }
     protected function getResultPdf() {
         // TODO Všechny getResultPdf() - přesunout do service+mapper pro ukládání, v kontroleru zůstane jen $view->getNewWindowOpenerCode() - pak vše doe getResult()
        if ($this->request->post('pdf') == "Tiskni IP 2.část - vyhodnocení aktivit") {
            $kurzyPlan = Projektor2_Viewmodel_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->getUserStatus()->getZajemce()->id);
            $view = new Projektor2_View_PDF_Vdtp_IP2($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast2';
            $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text)
                ->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name)
                ->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator)
                ->assign('znacka', $this->sessionStatus->getUserStatus()->getZajemce()->znacka)
//                ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)
                ->assign('aktivityPlan', $kurzyPlan);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
            $view->save($relativeFilePath);
            $htmlResult = $view->getNewWindowOpenerCode();
        }

        if ($this->request->post('pdf') == "Tiskni ukončení účasti") {
            $view = new Projektor2_View_PDF_Vdtp_Ukonceni($this->sessionStatus, $this->createContextFromModels());
            $file = 'ukonceni';
            //status proměnné
            $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text);
            $view->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name);
            $view->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator);
            $view->assign('znacka', $this->sessionStatus->getUserStatus()->getZajemce()->znacka);

            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
            $view->save($relativeFilePath);
            $htmlResult = $view->getNewWindowOpenerCode();
        }

        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení') === 0 ) {
            $datumCertif = $this->models['ukonceni']->datum_certif;
            $params = array('datumCertif' => $datumCertif);
            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Projekt($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();
        }

        return $htmlResult;
    }
}

