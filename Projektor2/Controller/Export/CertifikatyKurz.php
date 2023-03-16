<?php
/**
 * Exportuje do pdf ("tiskne") všechny dosud nevyexportované certifikáty pro aktuální projekt
 *
 * @author pes2704
 */
class Projektor2_Controller_Export_CertifikatyKurz extends Projektor2_Controller_Abstract {

    /**
     * Metoda exportuje do pdf všechny dosud nevyexportované certifikáty o absolvování kurzu pro aktuální projekt. Vytváří vždy originál i pseudokopii.
     * Vytvoří a uloží pdf pro všechny kurzy (aktivity typu kurz), které jsou s certifikátem (aktivita s certifikátem)
     * a které má zájemce v tabulce za_plan_flat_table zaznamenány jako dokončené úspěšně a se zadaným datem certifikátu, pokud již dříve nabyl
     * takový certifikát vytvořen. To zjišťuje v db tabulce certifikaty_kurz.
     * @return type
     */
    public function getResultOLD() {
        $zajemci = Projektor2_Model_Db_ZajemceMapper::findAllForProject();
        if ($zajemci) {
            ini_set('max_execution_time', Config_Certificates::getExportCertifMaxExucutionTime());
            $logger = Framework_Logger_File::getInstance(Config_AppContext::getLogsPath().'ExportCertikatu/', $this->sessionStatus->getUserStatus()->getProjekt()->kod.' Exportovane certifikaty projekt '.date('Ymd_His'));
            $aktivity = Config_Aktivity::findAktivity($this->sessionStatus->getUserStatus()->getProjekt()->kod, Config_Aktivity::TYP_KURZ);
            foreach ($aktivity as $indexAktivity => $aktivita) {
                if (isset($aktivita['tiskni_certifikat']) AND $aktivita['tiskni_certifikat']) {
                    $kurzyColumnNames[] = Projektor2_Model_Db_Flat_ZaPlanFlatTable::getItemColumnsNames($indexAktivity);
                }
            }
            foreach ($zajemci as $zajemce) {
                $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
//TODO:                pro všechny typy $certifikatTyp  !!

                foreach ($kurzyColumnNames as $kurzColumnNames) {
                    if ($plan->$kurzColumnNames['idSKurzFK'] AND $plan->$kurzColumnNames['dokonceno'] AND $plan->$kurzColumnNames['datumCertif']) {
                        $sKurz = Projektor2_Model_Db_SKurzMapper::get($plan->$kurzColumnNames['idSKurzFK']);
                        if (!$sKurz) {
                            throw new LogicException('Nekonzistence dat. Nelze vytvářet dokument certifikátu. Nenalezen kurz s id '
                                    .$plan->$kurzColumnNames['idSKurzFK'].', které bylo přečteno z tabulky '
                                    .$plan->getTableName().' pod id '.$plan->id.'.');
                        }
                        $serviceCertifikat = new Projektor2_Service_CertifikatKurz();
                        $certifikat = $serviceCertifikat->findCertifikat($zajemce, $sKurz, $certifikatTyp);
                        if (!$certifikat) {
                            $datumCertifikatu = $plan->$kurzColumnNames['datumCertif'];
                            $certicateType = 2;   // typ certifikátu = pseudokopie -> bude automaticky expotorván i originál
                            $certifikat = $serviceCertifikat->get(
                                $certicateType,
                                $this->sessionStatus,
                                Projektor2_Model_Db_KancelarMapper::getValid($zajemce->id_c_kancelar_FK),
                                $zajemce, $sKurz, $datumCertifikatu, $this->sessionStatus->getUserStatus()->getUser()->username, __CLASS__);
                            if (!$certifikat) {
                                throw new LogicException('Nepodařilo se vytvořit certifikát pro zajemce id: '.$this->sessionStatus->getUserStatus()->getZajemce()->id. ', kurz id: '.$sKurz->id_s_kurz);
                            }
                            $logger->log($certifikat->documentCertifikatKurz->filePath);
                        }
                    }
                }
            }
        }
        $redirController = new Projektor2_Controller_SeznamOsob($this->sessionStatus, $this->request, $this->response);
        return $redirController->getResult();
    }

    public function getResult() {
         // očekávám, že sKurz->kurz_druh odpovídá položce kurz_druh aktivit projektu v konfiguraci
        $konfiguraceAktivity =  Config_Aktivity::findAktivityPodleKurzDruh($this->sessionStatus->getUserStatus()->getProjekt()->kod, Config_Aktivity::TYP_KURZ, $this->sessionStatus->getUserStatus()->getSKurz()->kurz_druh);
        $aktivitaSCertifikatem = ($konfiguraceAktivity['s_certifikatem'] ?? null) ? TRUE : FALSE;
        if (!isset($aktivitaSCertifikatem) OR !$aktivitaSCertifikatem) {
            throw new LogicException("Došlo k pokusu o vytvoření certifikátů pro aktivitu bez certifikátu. Aktivita '$indexAktivity'.");
        }
        /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
        $aktivitaPlan = Projektor2_Viewmodel_AktivityPlanMapper::findByIndexAktivity($this->sessionStatus, $this->sessionStatus->getUserStatus()->getZajemce(), $indexAktivity);
        $createCertifikat = ($konfiguraceAktivity['certifikat']['original'] ?? null) ? TRUE : FALSE;
        $createCertifikatMonitoring = ($konfiguraceAktivity['certifikat']['monitoring'] ?? null) ? TRUE : FALSE;


        $zaPlanKurzArray = Projektor2_Model_Db_ZaPlanKurzMapper::findByFilter("id_s_kurz_FK={$this->sessionStatus->getUserStatus()->getSKurz()->id_s_kurz}");
            $inBinds = [];
            $i = 0;
            foreach ($zaPlanKurzArray as $zaPlanKurz) {
                $inBinds[':in'.$i++] = $zaPlanKurz->id_zajemce;
            }
            $inPlaceholders = implode(", ", array_keys($inBinds));

        $zajemci = Projektor2_Model_Db_ZajemceMapper::find("zajemce.id_zajemce IN ($inPlaceholders)", $inBinds, "identifikator");
        if ($zajemci) {
            ini_set('max_execution_time', Config_Certificates::getExportCertifMaxExucutionTime());
            $logger = Framework_Logger_File::getInstance(Config_AppContext::getLogsPath().'ExportCertikatu/', $this->sessionStatus->getUserStatus()->getProjekt()->kod.' Exportovane certifikaty projekt '.date('Ymd_His'));
            if ($createCertifikat) {
                $verze= 'original';
                $certifikat = $this->readOrCreateCertificate($aktivitaPlan, $verze, zajemce);
            }
            if ($createCertifikatMonitoring) {
                $verze= 'monitoring';
                $certifikat = $this->readOrCreateCertificate($aktivitaPlan, $verze, zajemce);
            }

            // TODO: aktualizovat datum certifikatu v db planu kurzu
        }
    }

    /**
     *
     * @param type $aktivitaPlan
     * @param type $certifikatVerze
     * @return Projektor2_Model_CertifikatKurz
     * @throws LogicException
     */
    private function readOrCreateCertificate(Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, $certifikatVerze, Projektor2_Model_Db_Zajemce $zajemce) {

        $certifikat = (new Projektor2_Service_CertifikatKurz())->get(
                $this->sessionStatus,
                $this->sessionStatus->getUserStatus()->getKancelar(),
                $zajemce,
                $aktivitaPlan->sKurz,
                $certifikatVerze,
                $aktivitaPlan->defaultDatumCertif,
                $this->sessionStatus->getUserStatus()->getUser()->name,
                __CLASS__
                );
        if (!$certifikat) {
            throw new LogicException('Nepodařilo se vytvořit verzi certifikátu: '.$certifikatVerze.' pro zajemce id: '.$this->sessionStatus->getUserStatus()->getZajemce()->id. ', kurz id: '.$sKurz->id_s_kurz);
        }

        if (!isset($aktivitaPlan->datumCertif)) {


        }
        return $certifikat;
    }
}
