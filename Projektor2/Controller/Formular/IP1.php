<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_IP1 extends Projektor2_Controller_Formular_IP {

    protected function createFormModels() {
        // Položky kontextu, které budou použity v elementech formuláře pro zadání (výběr) hodnot uživatelem,
        // t.j. elementy input, textarea, select, checkbox, radiobutton.
        // Kontext je asociativní pole, indexy kontextu se ve formuláři použijí jako jména (name) proměnných formuláře a hodnoty kontextu jako hodnoty (value) proměnných formuláře.
        //
        $this->models[Projektor2_Controller_Formular_FlatTable::PLAN_FT] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($this->sessionStatus->zajemce);
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->zajemce);
        $this->models[Projektor2_Controller_Formular_FlatTable::PLAN_KURZ] = new Projektor2_Model_Db_Flat_ZaPlanKurzCollection($this->sessionStatus->zajemce);
    }

    protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Config_Aktivity::findAktivity($this->sessionStatus->projekt->kod, Config_Aktivity::TYP_KURZ);
        $modelySKurz = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);

        $view = new Projektor2_View_HTML_Formular_IP1($this->sessionStatus, $this->createContextFromModels(TRUE));
        $view->assign('nadpis', 'INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA '.$this->sessionStatus->projekt->text)
            ->assign('aktivityTypuKurz', $aktivityProjektuTypuKurz)
            ->assign('modelySKurz', $modelySKurz)   // Projektor2_Model_Db_SKurz[]
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))
            ->assign('submitTiskIP1', array('name'=>'pdf', 'value'=>'Tiskni IP 1.část'));
        return $view;
    }

     protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 1.část") {
            $view = new Projektor2_View_PDF_Cjc_IP1($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast1_aktivity';
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka)
                ->assign('aktivityPlan', Projektor2_Viewmodel_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->zajemce))  // Projektor2_Model_AktivitaPlan[]
                    ;
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
            $view->save($relativeFilePath);
            $htmlResult = $view->getNewWindowOpenerCode();
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení Grafia') === 0 ) {
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení Grafia')));  // druh je řetězec za slovy Tiskni osvědčení Grafia
            $htmlResult = $this->getCertificateNewOpenerHtml($indexAktivity, 'original');
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení pro monitoring') === 0 ) {
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení pro monitoring')));  // druh je řetězec za slovy Tiskni osvědčení pro monitoring
            $htmlResult = $this->getCertificateNewOpenerHtml($indexAktivity, 'monitoring');
        }
        return $htmlResult;
    }

    private function getCertificateNewOpenerHtml($indexAktivity, $certifikatVerze) {

        $aktivityProjektuTypuKurz = Config_Aktivity::findAktivity($this->sessionStatus->projekt->kod, Config_Aktivity::TYP_KURZ);
        $konfiguraceAktivity = $aktivityProjektuTypuKurz[$indexAktivity];
        $aktivitaSCertifikatem = ($konfiguraceAktivity['s_certifikatem'] ?? null) ? TRUE : FALSE;
        if (!isset($aktivitaSCertifikatem) OR !$aktivitaSCertifikatem) {
            throw new LogicException("Došlo k pokusu o vytvoření certifikátů pro aktivitu bez certifikátu. Aktivita '$indexAktivity'.");
        }
        /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
        $aktivitaPlan = Projektor2_Viewmodel_AktivityPlanMapper::findByIndexAktivity($this->sessionStatus, $this->sessionStatus->zajemce, $indexAktivity);
        $createCertifikat = ($konfiguraceAktivity['certifikat']['original'] ?? null) ? TRUE : FALSE;
        $createCertifikatMonitoring = ($konfiguraceAktivity['certifikat']['monitoring'] ?? null) ? TRUE : FALSE;
        if ($createCertifikat) {
            $verze= 'original';
            $certifikat = $this->readOrCreateCertificate($aktivitaPlan, $verze);
            if ($verze==$certifikatVerze) {
                $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, ['certifikat'=>$certifikat]);
                $htmlResult = $ctrlIpCertifikat->getResult();  // NewWindowOpener
            }
        }
        if ($createCertifikatMonitoring) {
            $certifikatVerze = 'monitoring';
            if ($verze==$certifikatVerze) {
                $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, ['certifikat'=>$certifikat]);
                $htmlResult = $ctrlIpCertifikat->getResult();  // NewWindowOpener
            }
        }

        return $htmlResult;
    }

    /**
     *
     * @param type $aktivitaPlan
     * @param type $certifikatVerze
     * @return Projektor2_Model_CertifikatKurz
     * @throws LogicException
     */
    private function readOrCreateCertificate(Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, $certifikatVerze) {
        $certifikat = (new Projektor2_Service_CertifikatKurz())->get(
                $this->sessionStatus,
                $this->sessionStatus->kancelar,
                $this->sessionStatus->zajemce,
                $aktivitaPlan->sKurz,
                $certifikatVerze,
                $aktivitaPlan->datumCertif,
                $this->sessionStatus->user->name,
                __CLASS__
                );
        if (!$certifikat) {
            throw new LogicException('Nepodařilo se vytvořit verzi certifikátu: '.$certifikatVerze.' pro zajemce id: '.$this->sessionStatus->zajemce->id. ', kurz id: '.$sKurz->id_s_kurz);
        }
        return $certifikat;
    }
}
