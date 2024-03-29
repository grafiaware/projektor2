<?php
/**
 * Description of Projektor2_Model_CertifikatMapper
 *
 * @author pes2704
 */
class Projektor2_Service_CertifikatProjekt {

    /**
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Model_CertifikatKurz
     * @throws LogicException
     */
    public function findByZajemce(Projektor2_Model_Db_Zajemce $zajemce) {
        $modelDbCertifikat = Projektor2_Model_Db_CertifikatProjektMapper::findByZajemce($zajemce);
        if ($modelDbCertifikat) {
            $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatProjektOriginalMapper::findByRelativeFilepath($modelDbCertifikat->filename);
            if (!isset($modelDocumentCertifikatOriginal)) {
                throw new LogicException('Nalezen certifikat v databázi a nenalezen odpovídající soubor s pdf dokumentem. Certifikát id: '.$modelDbCertifikat->id
                        .', filename: '.Config_AppContext::getFileBaseFolder().$modelDbCertifikat->filename);
            }
            // Obsah není třeba - čte se soubor přes javascriptový opener. Kdyby byl potřeba, tak třeba takto:
//            $modelCertifikatProjektDokument = Projektor2_Model_File_CertifikatProjektOriginalMapper::hydrate($modelDocumentCertifikatOriginal);
            $modelCertifikatProjekt = new Projektor2_Model_CertifikatProjekt($modelDbCertifikat, $modelDocumentCertifikatOriginal);
            return $modelCertifikatProjekt;
        } else {
            return NULL;
        }

    }

    /**
     *
     * @param Projektor2_Model_Db_Projekt $sessionStatus->projekt
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param type $datumCertifikatu
     * @param type $creator
     * @return \Projektor2_Model_CertifikatProjekt
     * @throws LogicException
     * @throws RuntimeException
     */
    public function create(Projektor2_Model_Status $sessionStatus,
                Projektor2_Model_Db_Kancelar $kancelar,
                Projektor2_Model_Db_Zajemce $zajemce, $datumCertifikatu, $creator, $service) {

        $modelCertifikatProjekt = $this->findByZajemce($zajemce);
        if (!$modelCertifikatProjekt) {

            // vytvoř db certifikát - zatím bez filename
            $datetimeCertifikatu = Projektor2_Date::createFromCzechStringDate($datumCertifikatu);
            $modelDbCertifikat = Projektor2_Model_Db_CertifikatProjektMapper::create($zajemce, $datetimeCertifikatu, $creator, $service);  // bez filename
            // vytvoř a ulož pdf certifikátu
            $viewKurz = new Projektor2_View_PDF_Certifikat_ProjektOsvedceniOriginal();
            $relativeOriginalDocumentPath = Projektor2_Model_File_CertifikatProjektOriginalMapper::getRelativeFilePath($sessionStatus->getUserStatus()->getProjekt(), $zajemce);

            $content = $this->createContentCertifikatProjekt($viewKurz, $zajemce, $sessionStatus, $kancelar, $modelDbCertifikat, $relativeOriginalDocumentPath);
            $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatProjektOriginalMapper::create($sessionStatus->getUserStatus()->getProjekt(), $zajemce, $content);
            Projektor2_Model_File_CertifikatProjektOriginalMapper::save($modelDocumentCertifikatOriginal);

            // vytvoř a ulož pdf pseudokopie
            $viewKurz = new Projektor2_View_PDF_Certifikat_ProjektOsvedceniPseudokopie();
            $relativePseudokopieDocumentPath = Projektor2_Model_File_CertifikatProjektPseudokopieMapper::getRelativeFilePath($sessionStatus->getUserStatus()->getProjekt(), $zajemce);

            $content = $this->createContentCertifikatProjekt($viewKurz, $zajemce, $sessionStatus, $kancelar, $modelDbCertifikat, $relativeOriginalDocumentPath);
            $modelDocumentCertifikatPseudokopie = Projektor2_Model_File_CertifikatProjektPseudokopieMapper::create($sessionStatus->getUserStatus()->getProjekt(), $zajemce, $content);
            Projektor2_Model_File_CertifikatProjektPseudokopieMapper::save($modelDocumentCertifikatPseudokopie);

            // vytvořen file model certifikát i pseudokopie -> nastav název souboru certifikátu v db
            if ($modelDocumentCertifikatOriginal AND $modelDocumentCertifikatPseudokopie) {
                $modelDbCertifikat->filename = $modelDocumentCertifikatOriginal->relativeDocumentPath;
                Projektor2_Model_Db_CertifikatProjektMapper::update($modelDbCertifikat);
            } else {
                Projektor2_Model_Db_CertifikatProjektMapper::delete($modelDbCertifikat);  // nekontroluji smazání
                if (!$modelDocumentCertifikatOriginal) {
                    throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatOriginal->filePath);
                }
                if (!$modelDocumentCertifikatPseudokopie) {
                    throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatPseudokopie->filePath);
                }
            }
            $modelCertifikatProjekt = new Projektor2_Model_CertifikatProjekt($modelDbCertifikat, $modelDocumentCertifikatOriginal);
        }
        return $modelCertifikatProjekt;
    }

    /**
     * Vytvoří pdf soubor s certifikátem a file model certifikátu.
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_View_PDF_Common $pdfView
     * @param type $fileMapperClassName
     * @return Projektor2_Model_File_ItemAbstract
     */
//    private function createContentCertifikatProjekt(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_View_PDF_Common $pdfView) {
//        $models = $this->createProjektOsvedceniModels($zajemce);
//        $context = $this->createContextFromModels($models);
//        $pdfView->appendContext($context);
////        $viewKurz->appendContext(array(Projektor2_View_PDF_Ap_ProjektOsvedceni::MODEL_DOTAZNIK => $this->models[Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK]));
//        $pdfView->appendContext(array($pdfView::MODEL_DOTAZNIK => $models[$pdfView::MODEL_DOTAZNIK]));
//        $content = $pdfView->render();
//        return $content;
//    }

    /**
     *
     * @param Projektor2_View_PDF_Common $pdfView
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Status $sessionStatus
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_CertifikatKurz $certifikat
     * @param type $docPath
     * @return type
     */
    private function createContentCertifikatProjekt(Projektor2_View_PDF_Common $pdfView,
            Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Status $sessionStatus, Projektor2_Model_Db_Kancelar $kancelar,
            Projektor2_Model_Db_CertifikatProjekt $certifikat, $docPath) {
        $models = $this->createProjektOsvedceniModels($zajemce);
        $context = $this->createContextFromModels($models);
        $pdfView->appendContext($context);
        $texts = Config_Certificates::getCertificateTexts($sessionStatus);
        $pdfView->assign('signerName', $texts['signerName'])
            ->assign('signerPosition', $texts['signerPosition'])
            //TODO: natvrdo psát např. Plzeň - píše se kancelář, do které jsi přihlášen
            ->assign('kancelar_plny_text', $kancelar->plny_text)
            ->assign('certifikat', $certifikat)
            ->assign('file', $docPath)
            ->assign('v_projektu',$texts['v_projektu'])
            ->assign('financovan',$texts['financovan']);

//        $viewKurz->appendContext(array(Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK => $this->models[Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK]));
        $pdfView->appendContext(array($pdfView::MODEL_DOTAZNIK => $models[$pdfView::MODEL_DOTAZNIK]));
        $content = $pdfView->render();
        return $content;
    }

    /**
     * Vztvoří a vrací pole db modelů potřebných pto view.
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Service_CertifikatKurz
     */
    protected function createProjektOsvedceniModels(Projektor2_Model_Db_Zajemce $zajemce) {
         $models[Projektor2_View_PDF_Certifikat_ProjektOsvedceniOriginal::MODEL_UKONCENI] = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
         $models[Projektor2_View_PDF_Certifikat_ProjektOsvedceniOriginal::MODEL_DOTAZNIK]= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
         return $models;
    }

    /**
     * Vytvoří a vrací pole context vygenerované z modelů obsažených v $tjis->models. Pole context má indexy ve formě
     * 'index modelu'.'separator'.'název vlastnosti'. Např. pro model uložený jako $this->models['dotaznik'] a jeho vlastnost 'prijmeni'
     * vznikne prvek pole context s indexem 'dotaznik->prijmeni' a hodnotou vlastnosti.
     * @return array
     */
    protected function createContextFromModels($models) {
        foreach ($models as $modelSign => $model) {
            $assoc = $model->getValuesAssoc();
            foreach ($assoc as $key => $value) {
                $context[$modelSign.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.$key] = $value;
            }
        }
        return $context;
    }
}