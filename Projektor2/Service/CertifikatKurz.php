<?php
/**
 * Description of Projektor2_Model_CertifikatMapper
 *
 * @author pes2704
 */
class Projektor2_Service_CertifikatKurz {

    /**
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param int $certifikatTyp
     * @return \Projektor2_Model_CertifikatKurz
     * @throws LogicException
     */
    public function find(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, $certifikatTyp) {
        $modelyDbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::find($zajemce, $sKurz, $certifikatTyp);

        if ($modelyDbCertifikat) {
            if (count($modelyDbCertifikat) > 1) {
                throw new UnderflowException('V databázi nalezeno více certifikátů pro jednoho zájemce, kurz a typ. První je id: '.$modelyDbCertifikat[0]->id);
            }
            $modelDbCertifikat = $modelyDbCertifikat[0];
            $modelDocumentCertifikat = Projektor2_Model_File_CertifikatKurzMapper::findByRelativeFilepath($modelDbCertifikat->filename);
            if (!isset($modelDocumentCertifikat)) {
                throw new LogicException('Nalezen certifikat v databázi '.print_r($modelyDbCertifikat)
                        .' a nenalezen odpovídající soubor s pdf dokumentem. Certifikát id: '.$modelyDbCertifikat->id
                        .', filename: '.$_SERVER['DOCUMENT_ROOT'].'/'.Projektor2_AppContext::getFileBaseFolder().$modelyDbCertifikat->filename);
            }
            // Obsah není třeba - čte se soubor přes javascriptový opener. Kdyby byl potřeba, tak třeba takto:
//            $modelCertifikatKurzDokument = Projektor2_Model_File_CertifikatKurzOriginalMapper::hydrate($modelDocumentCertifikatOriginal);        } else {

            $modelCertifikatKurz = new Projektor2_Model_CertifikatKurz($modelDbCertifikat, $modelDocumentCertifikat);
            return $modelCertifikatKurz;
        } else {
            return NULL;
        }

    }

    /**
     *
     * @param Projektor2_Model_Db_Projekt $sessionStatus->projekt
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param type $datumCertifikatu
     * @param type $creator
     * @param type $service
     * @return \Projektor2_Model_CertifikatKurz
     * @throws RuntimeException
     */
    public function create($certificateType, Projektor2_Model_SessionStatus $sessionStatus,
                Projektor2_Model_Db_Kancelar $kancelar,
                Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, $datumCertifikatu, $creator, $service) {
            $logger = Framework_Logger_File::getInstance(Projektor2_AppContext::getLogsPath(), 'Certificates/'.date('Ymd').' CertificateCreation.log');  // denní logy - jméno začíná "číslem" dne

        $nalezenyCertifikatKurz = $this->find($zajemce, $sKurz, $certificateType);
        if (!$nalezenyCertifikatKurz) {

            // vytvoř db certifikát - zatím bez filename
            $datetimeCertifikatu = Projektor2_Date::createFromSqlDate($datumCertifikatu);
            $dbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::create($certificateType, $zajemce, $sKurz, $datetimeCertifikatu, $creator, $service);  // bez filename
            $logger->log('Certificate. Db certifikat kurz s id '.$dbCertifikat->id.' vytvořen.');
            switch ($certificateType) {
                case 1:
                case 2:
                    // vytvoř a ulož pdf certifikátu
                    $view = new Projektor2_View_PDF_KurzOsvedceniOriginal($sessionStatus);
                    $relativeDocumentPath = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, 1);

                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPath);
                    $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certificateType);
                    $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatOriginal);

                    // vytvoř a ulož pdf pseudokopie
                    $view = new Projektor2_View_PDF_KurzOsvedceniPseudokopie($sessionStatus);
                    // do obsahu pseudokopie se vkládá stejná cesta k souboru .pdf jako do originálu - reálně se ukládá do složky pro pseudokopie
                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPath);
                    $modelDocumentCertifikatPseudokopie = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certificateType);
                    $modelDocumentCertifikatPseudokopie = Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatPseudokopie);
                    // vytvořen file model certifikát i pseudokopie -> nastav název souboru certifikátu v db
                    if ($modelDocumentCertifikatOriginal AND $modelDocumentCertifikatPseudokopie) {
                        $logger->log('File certifikat kurz s cestou '.$modelDocumentCertifikatOriginal->filePath.' vytvořen.', 1);
                        $dbCertifikat->filename = $modelDocumentCertifikatOriginal->relativeDocumentPath;
                        Projektor2_Model_Db_CertifikatKurzMapper::update($dbCertifikat);
                        $logger->log('Db certifikat updatován.', 1);
                    } else {
                        Projektor2_Model_Db_CertifikatKurzMapper::delete($dbCertifikat);  // nekontroluji smazání
                        if (!$modelDocumentCertifikatOriginal) {
                            throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatOriginal->filePath);
                        }
                        if (!$modelDocumentCertifikatPseudokopie) {
                            throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatPseudokopie->filePath);
                        }
                    }
                    $nalezenyCertifikatKurz = new Projektor2_Model_CertifikatKurz($dbCertifikat, $modelDocumentCertifikatOriginal);
                    break;
                case 3:
                    // vytvoř a ulož pdf certifikátu pro ÚP
                    $view = new Projektor2_View_PDF_KurzOsvedceniPms($sessionStatus);
                    $relativeDocumentPath = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, 3);

                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPath);
                    $modelDocumentCertifikatMonitoring = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certificateType);
                    $modelDocumentCertifikatMonitoring = Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatMonitoring);
                    // vytvořen file model certifikát i pseudokopie -> nastav název souboru certifikátu v db
                    if ($modelDocumentCertifikatMonitoring) {
                        $logger->log('File certifikat kurz s cestou '.$modelDocumentCertifikatOriginal->filePath.' vytvořen.', 1);
                        $dbCertifikat->filename = $modelDocumentCertifikatMonitoring->relativeDocumentPath;
                        Projektor2_Model_Db_CertifikatKurzMapper::update($dbCertifikat);
                        $logger->log('Db certifikat updatován.', 1);
                    } else {
                        Projektor2_Model_Db_CertifikatKurzMapper::delete($dbCertifikat);  // nekontroluji smazání
                        throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatMonitoring->filePath);
                    }
                    $nalezenyCertifikatKurz = new Projektor2_Model_CertifikatKurz($dbCertifikat, $modelDocumentCertifikatMonitoring);
                    break;
                case 4:
                    // vytvoř a ulož pdf certifikátu pro CJC
                    $view = new Projektor2_View_PDF_KurzOsvedceniCjc($sessionStatus);
                    $relativeDocumentPath = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, 3);

                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPath);
                    $modelDocumentCertifikatMonitoring = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certificateType);
                    $modelDocumentCertifikatMonitoring = Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatMonitoring);
                    // vytvořen file model certifikát i pseudokopie -> nastav název souboru certifikátu v db
                    if ($modelDocumentCertifikatMonitoring) {
                        $logger->log('File certifikat kurz s cestou '.$modelDocumentCertifikatOriginal->filePath.' vytvořen.', 1);
                        $dbCertifikat->filename = $modelDocumentCertifikatMonitoring->relativeDocumentPath;
                        Projektor2_Model_Db_CertifikatKurzMapper::update($dbCertifikat);
                        $logger->log('Db certifikat updatován.', 1);
                    } else {
                        Projektor2_Model_Db_CertifikatKurzMapper::delete($dbCertifikat);  // nekontroluji smazání
                        throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatMonitoring->filePath);
                    }
                    $nalezenyCertifikatKurz = new Projektor2_Model_CertifikatKurz($dbCertifikat, $modelDocumentCertifikatMonitoring);
                    break;
                default:
                    throw new UnexpectedValueException('Neznámý typ certifikátu: '.$certificateType);
                    break;
            }

        } else {
            $logger->log('Nalezen certifikát. Db id: '.$nalezenyCertifikatKurz->dbCertifikatKurz->id.'. File path: '.$nalezenyCertifikatKurz->documentCertifikatKurz->filePath);
        }
        return $nalezenyCertifikatKurz;
    }

    /**
     * Vytvoří pdf soubor s certifikátem a file model certifikátu.
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_View_PDF_Common $pdfView
     * @param type $fileMapperClassName
     * @return Projektor2_Model_File_ItemAbstract
     */
    private function createContent(Projektor2_View_PDF_Common $pdfView,
            Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Kancelar $kancelar,
            Projektor2_Model_Db_CertifikatKurz $certifikat, Projektor2_Model_Db_SKurz $sKurz, $docPath) {
        $models = $this->createKurzOsvedceniModels($zajemce);
        $context = $this->createContextFromModels($models);
        $pdfView->appendContext($context);
        $texts = Projektor2_AppContext::getCertificateTexts($sessionStatus);
        $pdfView->assign('signerName', $texts['signerName'])
            ->assign('signerPosition', $texts['signerPosition'])
            //TODO: natvrdo psát např. Plzeň - píše se kancelář, do které jsi přihlášen
            ->assign('kancelar_plny_text', $kancelar->plny_text)
            ->assign('certifikat', $certifikat)
            ->assign('sKurz', $sKurz)
            ->assign('file', $docPath)
            ->assign('v_projektu',$texts['v_projektu'])
            ->assign('text_paticky',$texts['text_paticky']." ".$docPath)
            ->assign('financovan',$texts['financovan']);

//        $viewKurz->appendContext(array(Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK => $this->models[Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK]));
        $pdfView->appendContext(array($pdfView::MODEL_DOTAZNIK => $models[$pdfView::MODEL_DOTAZNIK]));
        $content = $pdfView->render();
        return $content;
    }

    /**
     * Přidá zadanému view go konzextu pozřebné proměnné
     * @param type $pdfView
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_CertifikatKurz $certifikat
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param type $docPath
     * @return type
     */
//    private function completeKurzOsvedceniView($pdfView, Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Kancelar $kancelar,
//                Projektor2_Model_Db_CertifikatKurz $certifikat, Projektor2_Model_Db_SKurz $sKurz, $docPath) {
//
//                    /*     */
//        return $pdfView;
//    }

    /**
     * Vztvoří a vrací pole db modelů potřebných pto view.
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Model_Db_Flat_ZaFlatTable
     */
    protected function createKurzOsvedceniModels(Projektor2_Model_Db_Zajemce $zajemce) {
         $models[Projektor2_View_PDF_KurzOsvedceniOriginal::MODEL_PLAN] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
         $models[Projektor2_View_PDF_KurzOsvedceniOriginal::MODEL_DOTAZNIK]= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
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