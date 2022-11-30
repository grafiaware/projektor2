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
//    public $date_konec;
//    public $dodavatel;

    private  $skupiny = array();

    public function __construct(Projektor2_Model_Db_SKurz $sKurz) {
        $this->id = $sKurz->id_s_kurz;
        $this->kurz_text = $this->textRetezecKurz($sKurz);
        $this->kurz_lokace = $sKurz->kurz_lokace;
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
                    .trim($kurz->beh_cislo) . "T_"
                    .trim($kurz->kurz_zkratka). " | "
                    .trim($kurz->kurz_nazev)." | "
                    .DateTime::createFromFormat('Y-m-d', trim($kurz->date_zacatek))->format('j.n.Y')." - "
                    .DateTime::createFromFormat('Y-m-d', trim($kurz->date_konec))->format('j.n.Y'). " | "
                    .trim($kurz->kancelar_kod);
        }
        return $ret;
    }
    public function setSkupina($name, Projektor2_Viewmodel_Menu_Skupina $skupina) {
        $this->skupiny[$name] = $skupina;
    }

    /**
     *
     * @param string $name
     * @return Projektor2_Viewmodel_Menu_Skupina
     */
    public function getSkupina($name) {
        return $this->skupiny[$name];
    }

    public function getSkupinyAssoc() {
        return $this->skupiny;
    }
}
?>
