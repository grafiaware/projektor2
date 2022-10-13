<?php
class Projektor2_Model_Db_SKurz implements Framework_Model_AttributeModelInterface {

    public $id_s_kurz;
    public $razeni;
    public $projekt_kod;
    public $kancelar_kod;
    public $kurz_druh;
    public $kurz_cislo;
    public $beh_cislo;
    public $kurz_lokace;
    public $kurz_zkratka;
    public $kurz_nazev;
    public $kurz_pracovni_cinnost;
    public $kurz_akreditace;
    public $kurz_obsah;
    public $pocet_hodin;
    public $pocet_hodin_distancne;
    public $pocet_hodin_praxe;
    public $date_zacatek;
    public $date_konec;
    public $dodavatel;
    public $valid;

    public function __construct($id_s_kurz=null, $razeni=null, $projekt_kod=null, $kancelar_kod=null,
                                $kurz_druh=null, $kurz_cislo=null, $beh_cislo=null, $kurz_lokace=null, $kurz_zkratka=null,
                                $kurz_nazev=null, $kurz_pracovni_cinnost=null, $kurz_akreditace=null, $kurz_obsah=null,
                                $pocet_hodin=null, $pocet_hodin_distancne=null, $pocet_hodin_praxe=null, $date_zacatek=null, $date_konec=null,
                                $dodavatel=null, $valid=null) {
        $this->id_s_kurz = $id_s_kurz;
        $this->razeni = $razeni;
        $this->projekt_kod = $projekt_kod;
        $this->kancelar_kod = $kancelar_kod;
        $this->kurz_druh = $kurz_druh;
        $this->kurz_cislo = $kurz_cislo;
        $this->beh_cislo = $beh_cislo;
        $this->kurz_lokace = $kurz_lokace;
        $this->kurz_zkratka = $kurz_zkratka;
        $this->kurz_nazev = $kurz_nazev;
        $this->kurz_pracovni_cinnost = $kurz_pracovni_cinnost;
        $this->kurz_akreditace = $kurz_akreditace;
        $this->kurz_obsah = $kurz_obsah;
        $this->pocet_hodin_distancne = $pocet_hodin_distancne;
        $this->pocet_hodin_praxe = $pocet_hodin_praxe;
        $this->pocet_hodin = $pocet_hodin;
        $this->date_zacatek = $date_zacatek;
        $this->date_konec = $date_konec;
        $this->dodavatel = $dodavatel;
        $this->valid = $valid;
    }

    /**
     * Info metoda pro signal a fieldset - hodnota jiná než * znamená skutečný kurz
     *
     * @return bool
     */
    public function isRealCourse() {
        return $this->kurz_zkratka <> '*';
    }
}
