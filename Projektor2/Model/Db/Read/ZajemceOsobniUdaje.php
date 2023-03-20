<?php
class Projektor2_Model_Db_Read_ZajemceOsobniUdaje {
    public $id;
    public $identifikator;
    public $znacka;
    public $titul;
    public $titul_za;
    public $jmeno;
    public $prijmeni;
    public $rodne_cislo;
    public $datum_narozeni;
    public $pohlavi;
    public $mobilni_telefon;
    public $mail;
    public $faze;
    public $registrace_zajemce;
    public $registrace_uchazec;
    public $rekvalifikace_zajemce;
    public $rekvalifikace_uchazec;
    public $datum_ukonceni;
    public $duvod_ukonceni;
    public $dokonceno, $datum_certif;
    public $zam_datum_vstupu;
    public $zam_forma;
    public $zam_nove_misto;
    public $zam_supm;
    public $zam_navazujici_datum_vstupu;


    public function __construct(
                $id=null, $identifikator=null, $znacka=null,
                $titul=null, $titul_za=null, $jmeno=null, $prijmeni=null, $rodne_cislo=null, $datum_narozeni=null,
                $pohlavi=null, $mobilni_telefon, $mail,
                $faze,
                $registrace_zajemce, $registrace_uchazec, $rekvalifikace_zajemce, $rekvalifikace_uchazec,
                $datum_ukonceni, $duvod_ukonceni, $dokonceno, $datum_certif,
                $zam_datum_vstupu, $zam_forma, $zam_nove_misto, $zam_supm, $zam_navazujici_datum_vstupu
            ) {
        $this->id = $id;
        $this->identifikator = $identifikator;
        $this->znacka = $znacka;
        $this->titul = $titul;
        $this->titul_za = $titul_za;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->rodne_cislo = $rodne_cislo;
        $this->datum_narozeni = $datum_narozeni;
        $this->pohlavi = $pohlavi;
        $this->mobilni_telefon = $mobilni_telefon;
        $this->mail = $mail;
        $this->faze = $faze;
        $this->registrace_zajemce = $registrace_zajemce;
        $this->registrace_uchazec = $registrace_uchazec;
        $this->rekvalifikace_zajemce = $rekvalifikace_zajemce;
        $this->rekvalifikace_uchazec = $registrace_uchazec;
        $this->datum_ukonceni = $datum_ukonceni;
        $this->duvod_ukonceni = $duvod_ukonceni;
        $this->dokonceno = $dokonceno;
        $this->datum_certif = $datum_certif;
        $this->zam_datum_vstupu = $zam_datum_vstupu;
        $this->zam_forma = $zam_forma;
        $this->zam_nove_misto = $zam_nove_misto;
        $this->zam_supm = $zam_supm;
        $this->zam_navazujici_datum_vstupu = $zam_navazujici_datum_vstupu;
    }
}
