<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_IP1 extends Projektor2_Controller_Formular_IP {

    protected function createFormModels() {
        // Položky kontextu, které budou použity v elementech formuláře pro zadání (výběr) hodnot uživatelem,
        // t.j. elementy input, textarea, select, checkbox, radiobutton.
        // Kontext je asociativní pole, indexy kontextu se ve formuláři použijí jako jména (name) proměnných formuláře a hodnoty kontextu jako hodnoty (value) proměnných formuláře.
        //
        $this->models[Projektor2_Controller_Formular_FlatTable::PLAN_FT] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());
        $this->models[Projektor2_Controller_Formular_FlatTable::PLAN_KURZ] = new Projektor2_Model_Db_Flat_ZaPlanKurzCollection($zajemce);
    }

    protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Config_Aktivity::findAktivity($this->sessionStatus->getUserStatus()->getProjekt()->kod, Config_Aktivity::TYP_KURZ);
        $modelyKurzu = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);

        $view = new Projektor2_View_HTML_Formular_IP1($this->sessionStatus, $this->createContextFromModels(TRUE));
        $view->assign('nadpis', 'INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Alternativní práce')
            ->assign('formAction', 'ap_plan_uc')
            ->assign('aktivityKurz', $aktivityProjektuTypuKurz)
            ->assign('modelyKurzu', $modelyKurzu)   // Projektor2_Model_Db_SKurz[]
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))
            ->assign('submitTiskIP1', array('name'=>'pdf', 'value'=>'Tiskni IP 1.část'));
        return $view;
    }

    protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 1.část") {
            $view = new Projektor2_View_PDF_Mb_IP1($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast1_aktivity';
            $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text)
                ->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name)
                ->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator)
                ->assign('znacka', $this->sessionStatus->getUserStatus()->getZajemce()->znacka)
                ->assign('aktivityPlan', Projektor2_Viewmodel_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->getUserStatus()->getZajemce()))  // Projektor2_Model_AktivitaPlan[]
                    ;
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

        $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení Grafia') === 0 ) {
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení Grafia')));  // druh je řetězec za slovy Tiskni osvědčení Grafia
            /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
            $aktivitaPlan = Projektor2_Viewmodel_AktivityPlanMapper::findByIndexAktivity($indexAktivity);
            $params = array('idSKurzFK'=>$aktivitaPlan->getUserStatus()->getSKurz()->id_s_kurz, 'datumCertif' => $aktivitaPlan->datumCertif, 'certifikatTyp'=>1);

            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení pro monitoring') === 0 ) {
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení pro monitoring')));  // druh je řetězec za slovy Tiskni osvědčení pro monitoring
            /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
            $aktivitaPlan = Projektor2_Viewmodel_AktivityPlanMapper::findByIndexAktivity($indexAktivity);
            $params = array('idSKurzFK'=>$aktivitaPlan->getUserStatus()->getSKurz()->id_s_kurz, 'datumCertif' => $aktivitaPlan->datumCertif, 'certifikatTyp'=>3);

            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();
        }
        return $htmlResult;
    }
}