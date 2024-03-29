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
     * @param Projektor2_Model_Status $sessionStatus
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan
     * @param string $datumCertifikatu
     * @param string $creator
     * @param string $service
     * @return \Projektor2_Model_CertifikatKurz
     * @throws RuntimeException
     * @throws UnexpectedValueException
     */
    public function get(
            Projektor2_Model_Status $sessionStatus,
            Projektor2_Model_Db_Kancelar $kancelar,
            Projektor2_Model_Db_Zajemce $zajemce,
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan,
            $certifikatVerze,
            $datumCertifikatu, $creator, $service
        ) {
        $logger = Framework_Logger_File::getInstance(Config_AppContext::getLogsPath().'Certificates/', date('Ymd').' CertificateCreation.log');  // denní logy - jméno začíná "číslem" dne
        $sKurz = $aktivitaPlan->sKurz;
        $certifikatRada = self::getRadaCislovani($sKurz, $certifikatVerze);
        $fullCertifikatKurz = $this->readCertifikat($zajemce, $sKurz, $certifikatRada, $certifikatVerze);

        if (!$fullCertifikatKurz) {
            $fullCertifikatKurz = $this->createCertifikat(
                    $sessionStatus, 
                    $kancelar, 
                    $zajemce, 
                    $aktivitaPlan, 
                    $certifikatVerze, 
                    $datumCertifikatu, $creator, $service);
            $logger->log('Vytvořen certifikát. Db id: '.$fullCertifikatKurz->dbCertifikatKurz->id.'. File path: '.$fullCertifikatKurz->documentCertifikatKurz->filePath);
        }
        return $fullCertifikatKurz;
    }

    /**
     * Vytvoří model certifikátu v zadané verzi.
     *
     * Vytvoří záznam v db, podle řady certifikátů v kurzu (s_kurz) vytvoří PDF obsah certifikátu,
     * file model certifikátu a uloží obsah (pdf) do složky dané identifikátorem kurzu a verzí certifikátu.
     * Výsledný model certifikátu obsahuje vzniklý db model a file model.
     *
     * @param Projektor2_Model_Status $sessionStatus
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param string $datumCertifikatu
     * @param string $creator
     * @param string $service
     * 
     * @return Projektor2_Model_CertifikatKurz
     */
    private function createCertifikat(
            Projektor2_Model_Status $sessionStatus,
            Projektor2_Model_Db_Kancelar $kancelar,
            Projektor2_Model_Db_Zajemce $zajemce,
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan,
            $certifikatVerze,
            $datumCertifikatu, $creator, $service
    ) {
        $sKurz = $aktivitaPlan->sKurz;

        // file certifikat model - bez content, ale filepath již vznikne
        $fileCertifikat = Projektor2_Model_File_CertifikatKurzMapper::create(
                $sessionStatus->getUserStatus()->getProjekt(), 
                $zajemce, 
                $sKurz, 
                $certifikatVerze);  // bez content

        // vytvoř db certifikát - jednu verzi
        $certifikatRada = self::getRadaCislovani($sKurz, $certifikatVerze);
        $datetimeCertifikatu = Projektor2_Date::createFromSqlDate($datumCertifikatu);
        try {
        $dbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::create(
                $zajemce, $sKurz, $certifikatRada, $certifikatVerze,
                $datetimeCertifikatu, $creator, $service, $fileCertifikat->relativeDocumentPath
            );
        } catch (Exception $e) {
            Projektor2_Model_File_CertifikatKurzMapper::delete($fileCertifikat);
            throw RuntimeException("Nepodařilo se zapsat údaje certifikátu do databáze. Certifikát nebude vytvořen.", 0, $e);
        }

        $content = $this->createContent($zajemce, $sessionStatus, $kancelar, $dbCertifikat, $aktivitaPlan, $fileCertifikat->relativeDocumentPath);
        if (!isset($content) OR !$content) {
            Projektor2_Model_File_CertifikatKurzMapper::delete($fileCertifikat);
            throw new RuntimeException("Nevznikl obsah souboru certifikátu pro kurz id: {$sKurz->id_s_kurz}.");
        }
        $fileCertifikat->setContent($content);
        try {
            Projektor2_Model_File_CertifikatKurzMapper::save($fileCertifikat);  // znovuvytvoření souboru a zápis content do souboru
        } catch (Exception $e) {
            throw RuntimeException("Nepodařilo se zapsat údaje certifikátu do souboru. Certifikát nebude vytvořen.", 0, $e);
        }
        return new Projektor2_Model_CertifikatKurz($dbCertifikat, $fileCertifikat);
    }

    private static function getRadaCislovani(Projektor2_Model_Db_SKurz $sKurz, $certifikatVerze) {
        /**
         *
         */
        switch ($certifikatVerze) {
            case 'monitoring':
                $certifikatRada = 'MO';
                break;
            default:
                $certifikatRada = $sKurz->certifikat_kurz_rada_FK;
                break;
        }
        if (!isset($certifikatRada) OR !$certifikatRada) {
            throw new UnexpectedValueException("Kurz nemá nastavenu číselnou řadu certifikátů. Nelze vytvořit certifikát pro kurz id: {$sKurz->id_s_kurz} a názvem: {$sKurz->kurz_nazev}.");
        }
        return $certifikatRada;
    }

    /**
     * Vytvoří objekt certifikat a nastaví mu přečtené db certifikát a file certifikát.
     * - db certifikát přečte podle zadaných paremetrů metody
     * - file certifikátpřečte podle cesty k souboru obsažené v db certifikátu
     *
     * Pokud nenalezne db certifikát v databázi, vrací null a nepokouší se načítatl file certifikát - nezná cestu s souboru. Důsledkem je, že soubory s certifikáty,
     * k nimž byl smazán záznam v databázi jsou "neviditelné", takyvý soubor je pak přepsán při vytvoření nového certifikátu pro zájemce, kurz, verze.
     *
     * Pokud nalezne více db certifikátů v db vyhazuje výjimku (více certifikátů jednoho uživatele v jednom kurzu a v jedné číselné řadě)
     * Pokud nalezne certifikát v databázi a chybí soubor s certifikátem vyhatuje výjimku.
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param type $certifikatRada
     * @param type $certifikatVerze
     * @return \Projektor2_Model_CertifikatKurz|null
     * @throws \OverflowException
     * @throws \LogicException
     */
    private function readCertifikat(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, $certifikatRada, $certifikatVerze) {
        // musí vracet jeden řádek - v tabulce je kombinace id_zajemce, id_s_Kurz, certifikat_rada, certifikat_verze UNIQUE index
        $modelyDbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::find($zajemce->id, $sKurz->id_s_kurz, $certifikatRada, $certifikatVerze);
        if ($modelyDbCertifikat) {   // neprázdné pole
            $modelDbCertifikat = $modelyDbCertifikat[0];
            try {
                $modelFileCertifikat = Projektor2_Model_File_CertifikatKurzMapper::findByRelativeFilepath($modelDbCertifikat->filename);
            } catch (\Exception $e) {
                throw new \LogicException("Nalezen certifikat v databázi a nenalezen odpovídající soubor s pdf dokumentem. Certifikát id: '{$modelDbCertifikat->id}'.", 0, $e);
            }
            $modelCertifikatKurz = new Projektor2_Model_CertifikatKurz($modelDbCertifikat, $modelFileCertifikat);
            return $modelCertifikatKurz;
        }
        return $modelCertifikatKurz ?? null;
    }

    /**
     * 
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Status $sessionStatus
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_CertifikatKurz $certifikat
     * @param Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan
     * @param type $docPath
     * @return type
     * @throws UnexpectedValueException
     */
    private function createContent(
            Projektor2_Model_Db_Zajemce $zajemce, 
            Projektor2_Model_Status $sessionStatus, 
            Projektor2_Model_Db_Kancelar $kancelar,
            Projektor2_Model_Db_CertifikatKurz $certifikat, 
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            $docPath) {

        switch ($certifikat->certifikat_kurz_rada_FK) {
            case 'PR':
                $pdfView = new Projektor2_View_PDF_Certifikat_KurzOsvedceniOriginal($sessionStatus);
                break;
            case 'MO':
                $pdfView = new Projektor2_View_PDF_Certifikat_KurzOsvedceniMonitoring($sessionStatus);
                break;
            case 'RK':
                $pdfView = new Projektor2_View_PDF_Certifikat_KurzOsvedceniAkreditovany($sessionStatus);
                break;
            case 'PrK':
                assert(false, 'Není implementováno PDF view pro profesní kvalifikaci.');
                break;
            default:
                throw new UnexpectedValueException("Nepodařilo se view pro vytvoření pdf certifikátu. Neznámá verze certifikátu: '{$certifikat->certifikat_kurz_verze_FK}'.");
        }        
        
        $models = $this->createKurzOsvedceniModels($zajemce);
        $context = $this->createContextFromModels($models);
        $texts = Config_Certificates::getCertificateTexts($sessionStatus);

        $pdfView->appendContext($context);
        $pdfView->assign('signerName', $texts['signerName'])
            ->assign('signerPosition', $texts['signerPosition'])
            //TODO: natvrdo psát např. Plzeň - píše se kancelář, do které jsi přihlášen
            ->assign('kancelar_plny_text', $kancelar->plny_text)
            ->assign('certifikat', $certifikat)
            ->assign('aktivitaPlanViewModel', $aktivitaPlan)
            ->assign('file', $docPath)
            ->assign('v_projektu',$texts['v_projektu'])
            ->assign('financovan',$texts['financovan']);
        $pdfView->appendContext(array($pdfView::MODEL_DOTAZNIK => $models[$pdfView::MODEL_DOTAZNIK]));
        
        $content = $pdfView->render();
        return $content;
    }

    /**
     * Vytvoří a vrací pole db modelů potřebných pro view.
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Model_Db_Flat_ZaFlatTable
     */
    protected function createKurzOsvedceniModels(Projektor2_Model_Db_Zajemce $zajemce) {
         $models[Projektor2_View_PDF_Certifikat_KurzOsvedceniOriginal::MODEL_PLAN] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
         $models[Projektor2_View_PDF_Certifikat_KurzOsvedceniOriginal::MODEL_DOTAZNIK]= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
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
            foreach ($model->getValuesAssoc() as $key => $value) {
                $context[$modelSign.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.$key] = $value;
            }
        }
        return $context;
    }
}