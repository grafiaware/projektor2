<?php
/**
 * Description of Projektor2_Model_KurzPlan
 *
 * @author pes2704
 */
class Projektor2_Model_AktivitaPlan  extends Framework_Model_DbItemAbstract {
    public $id;
    public $indexAktivity;
    public $nadpisAktivity;
    public $aktivitaSCertifikatem;
    public $tiskniCertifikat;
    public $tiskniCertifikatMonitoring;
    /**
     * @var Projektor2_Model_Db_SKurz
     */
    public $sKurz;
    public $pocAbsHodin;
    public $duvodAbsence;
    public $dokoncenoUspesne;
    public $duvodNeuspechu;
    public $datumCertif;
    /**
     * @var Projektor2_Model_Db_CertifikatKurz array of
     */
    public $certifikatyKurz;
    public $hodnoceni;

    public function __construct($id = NULL,$indexAktivity = NULL, $nadpisAktivity = NULL, $aktivitaSCertifikatem = NULL, $tiskniCertifikat = NULL, $tiskniCertifikatMonitoring = NULL,
            Projektor2_Model_Db_SKurz $sKurz = NULL,
            $pocAbsHodin = NULL, $duvodAbsence = NULL, $dokoncenoUspesne = NULL, $duvodNeuspechu = NULL, $datumCertif = NULL,
            $certifikatyKurz = NULL,

            $hodnoceni = NULL) {
        $this->id = $id;
        $this->indexAktivity = $indexAktivity;
        $this->nadpisAktivity = $nadpisAktivity;
        $this->aktivitaSCertifikatem = $aktivitaSCertifikatem;
        $this->tiskniCertifikat = $tiskniCertifikat;
        $this->tiskniCertifikatMonitoring = $tiskniCertifikatMonitoring;
        $this->sKurz = $sKurz;
        $this->pocAbsHodin = $pocAbsHodin;
        $this->duvodAbsence = $duvodAbsence;
        $this->dokoncenoUspesne = $dokoncenoUspesne;
        $this->duvodNeuspechu = $duvodNeuspechu;
        $this->datumCertif = $datumCertif;
        $this->certifikatyKurz = $certifikatyKurz;
        $this->hodnoceni = $hodnoceni;
    }
}
