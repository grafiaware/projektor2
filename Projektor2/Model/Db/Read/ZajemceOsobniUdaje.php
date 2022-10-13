<?php
class Projektor2_Model_Db_Read_ZajemceOsobniUdaje {
    public $id;
    public $identifikator;
    public $znacka;

    /**
     * @var Projektor2_Model_Db_Zajemce
     */
    public $zajemce;
    public $jmeno;
    public $prijmeni;
    public $rodne_cislo;
    public $datum_narozeni;
    public $pohlavi;
    public $titul;
    public $titul_za;

    public function __construct($id=null, $identifikator=null, $znacka=null, Projektor2_Model_Db_Zajemce $zajemce=NULL,
                            $jmeno=null, $prijmeni=null, $rodne_cislo=null, $datum_narozeni=null,
                            $pohlavi=null, $titul=null, $titul_za=null) {
        $this->id = $id;
        $this->identifikator = $identifikator;
        $this->znacka = $znacka;
        $this->zajemce = $zajemce;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->rodne_cislo = $rodne_cislo;
        $this->datum_narozeni = $datum_narozeni;
        $this->pohlavi = $pohlavi;
        $this->titul = $titul;
        $this->titul_za = $titul_za;
    }
}
