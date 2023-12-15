<?php
/**
 * Description of Projektor2_Model_KurzPlan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_AktivitaPlan  extends Framework_Model_DbItemAbstract {
    public $id;
    public $indexAktivity;
    public $nadpisAktivity;
    public $aktivitaSCertifikatem;

    /**
     * @var Projektor2_Viewmodel_AktivitaPlanCertifikatParams
     */
    public $certifikat;

    /**
     * @var Projektor2_Model_Db_SKurz
     */
    public $sKurz;

    public $pocAbsHodin;
    public $duvodAbsence;
    public $dokoncenoUspesne;
    public $duvodNeuspechu;
    public $datumCertif;
    public $datumZacatkuReal;
    public $datumKonceReal;
    public $datumZaverecneZkouskyReal;

    /**
     * @var Projektor2_Model_Db_CertifikatKurz array of
     */
    public $certifikatyKurz;
    public $hodnoceni;

    public function __construct(
            $id = null, $indexAktivity = null, $nadpisAktivity = null,
            $aktivitaSCertifikatem = null,
            Projektor2_Viewmodel_AktivitaPlanCertifikatParams $certifikatParams = null,
            Projektor2_Model_Db_ZaPlanKurz $planKurz = null,
            Projektor2_Model_Db_SKurz $sKurz = null,
            $certifikatyKurz = null) {
        $this->id = $id;
        $this->indexAktivity = $indexAktivity;
        $this->nadpisAktivity = $nadpisAktivity;
        $this->aktivitaSCertifikatem = $aktivitaSCertifikatem;
        $this->certifikat = $certifikatParams;
        
        $this->pocAbsHodin = $planKurz->poc_abs_hodin;
        $this->duvodAbsence = $planKurz->duvod_absence;
        $this->dokoncenoUspesne = $planKurz->dokonceno;
        $this->duvodNeuspechu = $planKurz->duvod_neukonceni;
        $this->datumCertif = $planKurz->date_certif;
        $this->datumZacatkuReal = $planKurz->date_zacatek_extra ?? $sKurz->date_zacatek;
        $this->datumKonceReal = $planKurz->date_konec_extra ?? $sKurz->date_konec;
        $this->datumZaverecneZkouskyReal = $planKurz->date_zaverecna_zkouska_extra ?? $sKurz->date_zaverecna_zkouska;
        
        $this->sKurz = $sKurz;
        $this->certifikatyKurz = $certifikatyKurz;
    }
}
