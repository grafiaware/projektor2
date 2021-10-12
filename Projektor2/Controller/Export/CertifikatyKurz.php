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
    public function getResult() {
        $zajemci = Projektor2_Model_Db_ZajemceMapper::findAllForProject();
        if ($zajemci) {
            ini_set('max_execution_time', Projektor2_AppContext::getExportCertifMaxExucutionTime());
            $logger = Framework_Logger_File::getInstance(Projektor2_AppContext::getLogsPath().'ExportCertikatu/', $this->sessionStatus->projekt->kod.' Exportovane certifikaty projekt '.date('Ymd_His'));
            $aktivity = Projektor2_AppContext::getAktivityProjektuTypu($this->sessionStatus->projekt->kod, 'kurz');
            foreach ($aktivity as $indexAktivity => $aktivita) {
                if (isset($aktivita['tiskni_certifikat']) AND $aktivita['tiskni_certifikat']) {
                    $kurzyColumnNames[] = Projektor2_Model_Db_Flat_ZaPlanFlatTable::getItemColumnsNames($indexAktivity);
                }
            }
            foreach ($zajemci as $zajemce) {
                $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
                pro všechny typy $certifikatTyp  !!

                foreach ($kurzyColumnNames as $kurzColumnNames) {
                    if ($plan->$kurzColumnNames['idSKurzFK'] AND $plan->$kurzColumnNames['dokonceno'] AND $plan->$kurzColumnNames['datumCertif']) {
                        $sKurz = Projektor2_Model_Db_SKurzMapper::get($plan->$kurzColumnNames['idSKurzFK']);
                        if (!$sKurz) {
                            throw new LogicException('Nekonzistence dat. Nelze vytvářet dokument certifikátu. Nenalezen kurz s id '
                                    .$plan->$kurzColumnNames['idSKurzFK'].', které bylo přečteno z tabulky '
                                    .$plan->getTableName().' pod id '.$plan->id.'.');
                        }
                        $serviceCertifikat = new Projektor2_Service_CertifikatKurz();
                        $certifikat = $serviceCertifikat->find($zajemce, $sKurz, $certifikatTyp);
                        if (!$certifikat) {
                            $datumCertifikatu = $plan->$kurzColumnNames['datumCertif'];
                            $certicateType = 2;   // typ certifikátu = pseudokopie -> bude automaticky expotorván i originál
                            $certifikat = $serviceCertifikat->create($this->sessionStatus,
                                                Projektor2_Model_Db_KancelarMapper::findById($zajemce->id_c_kancelar_FK),
                                                $zajemce, $sKurz, $datumCertifikatu, $this->sessionStatus->user->username, __CLASS__);
                            if (!$certifikat) {
                                throw new LogicException('Nepodařilo se vytvořit certifikát pro zajemce id: '.$this->sessionStatus->zajemce->id. ', kurz id: '.$sKurz->id);
                            }
                            $logger->log($certifikat->documentCertifikatKurz->filePath);
                        }
                    }
                }
            }
        }
        $redirController = new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
        return $redirController->getResult();
    }
}
