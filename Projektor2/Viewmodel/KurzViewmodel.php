<?php

class Projektor2_Viewmodel_KurzViewmodel {
    public $id;
    public $kurz_text;
    public $kurz_lokace;
//    public $kurz_zkratka;
//    public $kurz_nazev;
//    public $kurz_pracovni_cinnost;
//    public $kurz_akreditace;
//    public $kurz_obsah;
//    public $pocet_hodin;
//    public $pocet_hodin_distancne;
//    public $pocet_hodin_praxe;
//    public $date_zacatek;
    public $date_konec;
//    public $dodavatel;

    private  $skupiny = array();

    public function __construct(Projektor2_Model_Db_SKurz $sKurz) {
        $this->id = $sKurz->id_s_kurz;
        $this->kurz_text = $this->textRetezecKurz($sKurz);
        $this->kurz_lokace = $sKurz->kurz_lokace;
        $this->date_konec = $sKurz->date_konec;
    }

    /**
     * Callback funkce pro view  Projektor2_View_HTML_Element_Select.
     * @param Projektor2_Model_Db_SKurz $kurz
     * @return string
     */
    private function textRetezecKurz(Projektor2_Model_Db_SKurz $kurz) {
        if ($kurz->kurz_zkratka == '*') {
            $ret = $kurz->kurz_nazev;
        } else {
            $ret = trim($kurz->projekt_kod). "_"
                    .trim($kurz->kurz_druh). "_"
                    .trim($kurz->kurz_cislo) . "_"
//                    .trim($kurz->beh_cislo) . "T_"
                    .trim($kurz->kurz_zkratka). " | "
                    .trim($kurz->kurz_nazev)." | "
                    .DateTime::createFromFormat('Y-m-d', trim($kurz->date_zacatek))->format('j.n.Y')." - "
                    .DateTime::createFromFormat('Y-m-d', trim($kurz->date_konec))->format('j.n.Y'). " | "
                    ."zk: ".DateTime::createFromFormat('Y-m-d', trim($kurz->date_zaverecna_zkouska))->format('j.n.Y'). " | "
                    . mb_substr(trim($kurz->info_cas_konani), 0, 18)." | "
                    . mb_substr(trim($kurz->info_misto_konani), 0, 12)." | "
                    . mb_substr(trim($kurz->info_lektor), 0, 12)." | "
                    .trim($kurz->kancelar_kod);
        }
        return $ret;
    }
    public function addGroup($name, Projektor2_Viewmodel_Menu_Group $skupina) {
        $this->skupiny[$name] = $skupina;
    }

    /**
     *
     * @param string $name
     * @return Projektor2_Viewmodel_Menu_Group
     */
    public function getGroup($name) {
        return $this->skupiny[$name];
    }

    public function getGroups() {
        return $this->skupiny;
    }
}
?>
