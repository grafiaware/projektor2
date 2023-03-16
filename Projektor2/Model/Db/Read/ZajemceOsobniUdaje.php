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


    public function __construct($id=null, $identifikator=null, $znacka=null, 
                            $titul=null, $titul_za=null, $jmeno=null, $prijmeni=null, $rodne_cislo=null, $datum_narozeni=null,
                            $pohlavi=null) {
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

    }
}
