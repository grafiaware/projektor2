<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZaPlanKurz
 *
 * @author pes2704
 */
class Projektor2_Model_Db_ZaPlanKurz {

    public $id_za_plan_kurz;
    public $id_zajemce;
    public $id_s_kurz_FK;
    public $kurz_druh_fk;
    public $aktivita;
    public $text;
    public $poc_abs_hodin;
    public $duvod_absence;
    public $dokonceno;
    public $duvod_neukonceni;
    public $datum_certif;

    public function __construct(
            $id_za_plan_kurz = null,
            $id_zajemce = null,
            $id_s_kurz_FK = null,
            $kurz_druh_fk = null,
            $aktivita = null,
            $text = null,
            $poc_abs_hodin = null,
            $duvod_absence = null,
            $dokonceno = null,
            $duvod_neukonceni = null,
            $datum_certif = null) {
        $this->id_za_plan_kurz = $id_za_plan_kurz;
        $this->id_zajemce = $id_zajemce;
        $this->id_s_kurz_FK = $id_s_kurz_FK;
        $this->kurz_druh_fk = $kurz_druh_fk;
        $this->aktivita = $aktivita;
        $this->text = $text;
        $this->poc_abs_hodin = $poc_abs_hodin;
        $this->duvod_absence = $duvod_absence;
        $this->dokonceno = $dokonceno;
        $this->duvod_neukonceni = $duvod_neukonceni;
        $this->datum_certif = $datum_certif;
    }
}
