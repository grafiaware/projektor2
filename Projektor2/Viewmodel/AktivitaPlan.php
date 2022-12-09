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

    public $defaultDatumCertif;

    /**
     * @var Projektor2_Model_Db_CertifikatKurz array of
     */
    public $certifikatyKurz;
    public $hodnoceni;

    public function __construct(
            $id = null, $indexAktivity = null, $nadpisAktivity = null,
            $aktivitaSCertifikatem = null,
            Projektor2_Viewmodel_AktivitaPlanCertifikatParams $certifikat = null,
            Projektor2_Model_Db_SKurz $sKurz = null,
            $pocAbsHodin = null, $duvodAbsence = null, $dokoncenoUspesne = null, $duvodNeuspechu = null, $datumCertif = null,
            $certifikatyKurz = null,
            $hodnoceni = null) {
        $this->id = $id;
        $this->indexAktivity = $indexAktivity;
        $this->nadpisAktivity = $nadpisAktivity;
        $this->aktivitaSCertifikatem = $aktivitaSCertifikatem;
        $this->certifikat = $certifikat;
        $this->sKurz = $sKurz;
        $this->pocAbsHodin = $pocAbsHodin;
        $this->duvodAbsence = $duvodAbsence;
        $this->dokoncenoUspesne = $dokoncenoUspesne;
        $this->duvodNeuspechu = $duvodNeuspechu;
        $this->datumCertif = $datumCertif;
        $this->certifikatyKurz = $certifikatyKurz;
        $this->hodnoceni = $hodnoceni;

        $this->defaultDatumCertif =
                $datumCertif = $this->datumCertif
                ? $this->datumCertif
                : ($this->sKurz->date_zaverecna_zkouska ? $this->sKurz->date_zaverecna_zkouska : $this->sKurz->date_konec);

    }
}
