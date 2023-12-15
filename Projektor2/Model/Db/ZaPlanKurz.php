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
    public $poc_abs_hodin_distancne;
    public $poc_abs_hodin_praxe;
    public $duvod_absence;
    public $dokonceno;
    public $duvod_neukonceni;
    public $date_certif;
    public $date_zacatek_extra;
    public $date_konec_extra;
    public $date_zaverecna_zkouska_extra;
    
    public function __construct(
            $id_za_plan_kurz = null,
            $id_zajemce = null,
            $id_s_kurz_FK = null,
            $kurz_druh_fk = null,
            $aktivita = null,
            $text = null,
            $poc_abs_hodin = null,
            $poc_abs_hodin_distancne = null,
            $poc_abs_hodin_praxe = null,
            $duvod_absence = null,
            $dokonceno = null,
            $duvod_neukonceni = null,
            $date_certif = null,
            $date_zacatek_extra = null,
            $date_konec_extra = null,
            $date_zaverecna_zkouska_extra = null) {
        $this->id_za_plan_kurz = $id_za_plan_kurz;
        $this->id_zajemce = $id_zajemce;
        $this->id_s_kurz_FK = $id_s_kurz_FK;
        $this->kurz_druh_fk = $kurz_druh_fk;
        $this->aktivita = $aktivita;
        $this->text = $text;
        $this->poc_abs_hodin = $poc_abs_hodin;
        $this->poc_abs_hodin_distancne = $poc_abs_hodin_distancne;
        $this->poc_abs_hodin_praxe = $poc_abs_hodin_praxe;
        $this->duvod_absence = $duvod_absence;
        $this->dokonceno = $dokonceno;
        $this->duvod_neukonceni = $duvod_neukonceni;
        $this->date_certif = $date_certif;
        $this->date_zacatek_extra = $date_zacatek_extra;
        $this->date_konec_extra =$date_konec_extra;
        $this->date_zaverecna_zkouska_extra = $date_zaverecna_zkouska_extra;
    }
}
