<?php

class Projektor2_Viewmodel_KurzViewmodel {
    public $id;
    public $infoKurzText;
    public $infoKurzLokace;
    public $jeZadanPocetHodin;
    /**
     * 
     * @var Projektor2_Model_Db_SKurz
     */
    public $sKurz;

    private  $skupiny = array();

    public function __construct(Projektor2_Model_Db_SKurz $sKurz) {
        $this->id = $sKurz->id_s_kurz;
        $this->infoKurzText = $this->textRetezecKurz($sKurz);  // pro seznam kurzů a select v kurz fieldset
        $this->infoKurzLokace = $sKurz->kurz_lokace;  // pro seznam kurzů
        $this->jeZadanPocetHodin = $this->jeZadanPocetHodin($sKurz); // pro kurz fieldset - pokud je počet hodin zobrazí se údaje absolvováno
        $this->sKurz = $sKurz;
    }

    private function jeZadanPocetHodin(Projektor2_Model_Db_SKurz $sKurz) {
        return ($sKurz->pocet_hodin??0 || $sKurz->pocet_hodin_distancne??0 || $sKurz->pocet_hodin_praxe??0);
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
                $datetimeZacatek = DateTime::createFromFormat('Y-m-d', trim($kurz->date_zacatek));
                $datetimeKonec = DateTime::createFromFormat('Y-m-d', trim($kurz->date_konec));
                $datetimeZkouska = DateTime::createFromFormat('Y-m-d', trim($kurz->date_zaverecna_zkouska));
                $ret = trim($kurz->projekt_kod). "_"
                    .trim($kurz->kurz_druh). "_"
                    .trim($kurz->kurz_cislo) . "_"
//                    .trim($kurz->beh_cislo) . "T_"
                    .trim($kurz->kurz_zkratka). " | "
                    .trim($kurz->kurz_nazev)." | "
                    .($datetimeZacatek ? $datetimeZacatek->format('j.n.Y'):"")." - " 
                    .($datetimeKonec ? $datetimeKonec->format('j.n.Y'):""). " | "
                    ."zk: ".($datetimeZkouska ? $datetimeZkouska->format('j.n.Y'):""). " | "
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
