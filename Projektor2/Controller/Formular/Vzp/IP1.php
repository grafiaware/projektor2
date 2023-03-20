<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Vzp_IP1 extends Projektor2_Controller_Formular_IP {

    protected function createFormModels() {
        $this->models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
        $this->models['dotaznik'] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
    }

    protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Config_Aktivity::findAktivity($this->sessionStatus->getUserStatus()->getProjekt()->kod, Config_Aktivity::TYP_KURZ);
        $kurzyModelsAssoc = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);
        $kurzyPlanAssoc = Projektor2_Viewmodel_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->getUserStatus()->getZajemce());

        $view = new Projektor2_View_HTML_Formular_IP1($this->sessionStatus, $this->createContextFromModels(TRUE));
        $view->assign('nadpis', 'INDIVIDUÁLNÍ PLÁN účastníka programu Vykroč za prací projektu „Vzdělávání a dovednosti pro trh práce II“ ')
            ->assign('formAction', 'vzp_plan_uc')
            ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)
            ->assign('kurzyModels', $kurzyModelsAssoc)
            ->assign('aktivityPlan', $kurzyPlanAssoc)
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))
            ->assign('submitTiskIP1', array('name'=>'pdf', 'value'=>'Tiskni IP 1.část'));
        return $view;
    }

     protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 1.část") {
            $kurzyPlan = Projektor2_Viewmodel_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->getUserStatus()->getZajemce()->id);
            $view = new Projektor2_View_PDF_Vzp_IP1($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast1_aktivity';
            $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text)
                ->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name)
                ->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator)
                ->assign('znacka', $this->sessionStatus->getUserStatus()->getZajemce()->znacka)
                ->assign('aktivityPlan', $kurzyPlan);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
            $view->save($relativeFilePath);
            $htmlResult = $view->getNewWindowOpenerCode();
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení Grafia') === 0 ) {
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení Grafia')));  // druh je řetězec za slovy Tiskni osvědčení Grafia
            $kurzPlan = Projektor2_Viewmodel_AktivityPlanMapper::findByIndexAktivity($indexAktivity);
            $params = array('idSKurzFK'=>$kurzPlan->getUserStatus()->getSKurz()->id_s_kurz, 'datumCertif' => $kurzPlan->datumCertif, 'certifikatTyp'=>1);

            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení pro monitoring') === 0 ) {
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení pro monitoring')));  // druh je řetězec za slovy Tiskni osvědčení pro monitoring
            $kurzPlan = Projektor2_Viewmodel_AktivityPlanMapper::findByIndexAktivity($indexAktivity);
            $params = array('idSKurzFK'=>$kurzPlan->getUserStatus()->getSKurz()->id_s_kurz, 'datumCertif' => $kurzPlan->datumCertif, 'certifikatTyp'=>3);

            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();
        }
        return $htmlResult;
    }
}
