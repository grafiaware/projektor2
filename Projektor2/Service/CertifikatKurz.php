<?php
/**
 * Description of Projektor2_Model_CertifikatMapper
 *
 * @author pes2704
 */
class Projektor2_Service_CertifikatKurz {


    /**
     *
     * @param string $certifikatRada
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param string $datumCertifikatu
     * @param string $creator
     * @param string $service
     * @return \Projektor2_Model_CertifikatKurz
     * @throws RuntimeException
     * @throws UnexpectedValueException
     */
    public function create(
            $certifikatVerze,
            Projektor2_Model_SessionStatus $sessionStatus,
            Projektor2_Model_Db_Kancelar $kancelar,
            Projektor2_Model_Db_Zajemce $zajemce,
            Projektor2_Model_Db_SKurz $sKurz,
            $datumCertifikatu, $creator, $service
        ) {

        $certifikatRada = $sKurz->certifikat_kurz_rada_FK;
        if (!isset($certifikatRada) OR !$certifikatRada) {
            throw new UnexpectedValueException("Kurz nemá nastavenu číselnou řadu certifikátů. Nelze vytvořit certifikát pro kurz id: {$sKurz->id_s_kurz} a názvem: {$sKurz->kurz_nazev}.");
        }

        $logger = Framework_Logger_File::getInstance(Projektor2_AppContext::getLogsPath(), 'Certificates/'.date('Ymd').' CertificateCreation.log');  // denní logy - jméno začíná "číslem" dne
        $fullCertifikatKurz = $this->getCertifikat($zajemce, $sKurz, $certifikatRada);

        if (!$fullCertifikatKurz) {
            $logger->log('Certificate. Db CertifikatKurz s id '.$dbCertifikat->id.' vytvořen.');
        } else {
            $logger->log('Nalezen certifikát. Db id: '.$fullCertifikatKurz->dbCertifikatKurz->id.'. File path: '.$fullCertifikatKurz->documentCertifikatKurz->filePath);
        }
        switch ($certifikatVerze) {
                case 'original':  // originál
                case 'pseudokopie': // pseudokopie
                    // vytvoř a ulož pdf certifikátu
                    switch ($certifikatRada) {
                        case 'PR':

                            $view = new Projektor2_View_PDF_KurzOsvedceniOriginal($sessionStatus);
                            break;
                        case 'MO':
                            $view = new Projektor2_View_PDF_KurzOsvedceniPms($sessionStatus);
                            break;
                        case 'RK':
                            $view = new Projektor2_View_PDF_KurzOsvedceniAkreditovany($sessionStatus);
                            break;
                        case 'PrK':
                            assert(false, 'Není implementováno PDF view pro profesní kvalifikaci.');

                            break;
                        default:
                            break;
                    }


                    // tato hodnota cesty k souboru se vkládá jen do contentu (metoda CertifikatKurzMapper::create si vždy vygeneruje cestu podle verze certifikátu )
                    $relativeDocumentPathForContent = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, $certifikatVerze);

                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPathForContent);
                    $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certifikatVerze);
                    Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatOriginal);

                    // vytvoř a ulož pdf pseudokopie
                    $view = new Projektor2_View_PDF_KurzOsvedceniPseudokopie($sessionStatus);
                    // do obsahu pseudokopie se vkládá stejná cesta k souboru .pdf jako do originálu - reálně se ukládá do složky pro pseudokopie
                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPathForContent);
                    $modelDocumentCertifikatPseudokopie = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certifikatVerze);
                    Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatPseudokopie);
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
                    $fullCertifikatKurz = new Projektor2_Model_CertifikatKurz($dbCertifikat, $modelDocumentCertifikatOriginal);
                    break;
                case 'monitoring': // monitoring
                    // vytvoř a ulož pdf certifikátu pro ÚP
                    $view = new Projektor2_View_PDF_KurzOsvedceniPms($sessionStatus);
                    $relativeDocumentPathForContent = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, $certifikatRada);

                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPathForContent);
                    $modelDocumentCertifikatMonitoring = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certifikatRada);
                    Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatMonitoring);
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
                    $fullCertifikatKurz = new Projektor2_Model_CertifikatKurz($dbCertifikat, $modelDocumentCertifikatMonitoring);
                    break;
                case 4: // akreditovaný kurz
                    // vytvoř a ulož pdf certifikátu pro akreditovaný kurz
                    $view = new Projektor2_View_PDF_KurzOsvedceniAkreditovany($sessionStatus);
                    $relativeDocumentPathForContent = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, $certifikatRada);

                    $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPathForContent);
                    $modelDocumentCertifikatMonitoring = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $content, $certifikatRada);
                    Projektor2_Model_File_CertifikatKurzMapper::save($modelDocumentCertifikatMonitoring);
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
                    $fullCertifikatKurz = new Projektor2_Model_CertifikatKurz($dbCertifikat, $modelDocumentCertifikatMonitoring);
                    break;
                default:
                    throw new UnexpectedValueException('Neznámý typ certifikátu: '.$certifikatRada);
                    break;
            }


        return $fullCertifikatKurz;
    }

    private function createCertifikat() {
            // tato hodnota cesty k souboru se vkládá jen do contentu (metoda CertifikatKurzMapper::create si vždy vygeneruje cestu podle verze certifikátu )

            $fileCertifikat = Projektor2_Model_File_CertifikatKurzMapper::create($sessionStatus->projekt, $zajemce, $sKurz, $certifikatVerze);  // bez content
            $relativeDocumentPathForContent = Projektor2_Model_File_CertifikatKurzMapper::getRelativeFilePath($sessionStatus->projekt, $zajemce, $sKurz, $certifikatVerze);
            $content = $this->createContent($view, $zajemce, $sessionStatus, $kancelar, $dbCertifikat, $sKurz, $relativeDocumentPathForContent);
            $fileCertifikat->setContent($content);
            Projektor2_Model_File_CertifikatKurzMapper::save($fileCertifikat);  // vytvoření a zápis do souboru

            // vytvoř db certifikát - zatím bez filename
            $datetimeCertifikatu = Projektor2_Date::createFromSqlDate($datumCertifikatu);
            $dbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::create(
                    $certifikatRada,
                    $zajemce,
                    $sKurz,
                    $datetimeCertifikatu,
                    $creator,
                    $service,
                    $fileCertifikat->filePath
                );
            if (is_null($dbCertifikat)) {

            }
    }
    /**
     * Přečte objekt cerifikat, přečte db cerifikát a podle v něm obsažené cesty k souboru přečte file certifikát.
     *
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param string $certifikatRada
     * @return \Projektor2_Model_CertifikatKurz
     * @throws LogicException
     */
    private function getCertifikat(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, $certifikatRada) {
        $modelyDbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::find($zajemce, $sKurz, $certifikatRada);

        if ($modelyDbCertifikat) {   // neprázdné pole
            if (count($modelyDbCertifikat) > 1) {
                throw new UnderflowException('V databázi nalezeno více certifikátů pro jednoho zájemce, kurz a typ. První je id: '.$modelyDbCertifikat[0]->id);
            }
            $modelDbCertifikat = $modelyDbCertifikat[0];
            try {
                $modelFileCertifikat = Projektor2_Model_File_CertifikatKurzMapper::findByRelativeFilepath($modelDbCertifikat->filename);
            } catch (\Exception $e) {
                throw new \LogicException("Nalezen certifikat v databázi a nenalezen odpovídající soubor s pdf dokumentem. Certifikát id: '{$modelDbCertifikat->id_s_kurz_FK}', cesta: {$modelDbCertifikat->filename}'.", 0, $e);
            }
            $modelCertifikatKurz = new Projektor2_Model_CertifikatKurz($modelDbCertifikat, $modelFileCertifikat);
            return $modelCertifikatKurz;
        } else {
            return NULL;
        }

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