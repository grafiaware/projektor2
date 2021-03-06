<?php
/**
 * Description of Projektor2_Controller_Formular_HelpIP
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_IP extends Projektor2_Controller_Formular_Base {

    /**
     * Metoda vrací pole objektů Projektor2_Model_SKurz pro aktuální projekt, běh, kancelář a zadaný druh kurzu.
     * Metoda vytvoří filtr z kontextu aplikace
     * (projekt, běh a kancelář) a druhu kurzu zadaného jako parametr. Do výběru přidá vždy i kurzy,
     * kde kurz_zkratka='*'. S tímto filtrem pak volá Projektor2_Model_SKurzMapper, metodu findAll().
     *
     * @param string $kurz_druh Parametr musí obsahovat hodnotu ze sloupce kurz_druh db tabulky s_kurz
     * @param type $default TRUE - metoda vrací i model z tabulky s_kurz se zkratkou kurzu '*', tento model pak může být defaulní hodnotou v selectu
     * @return Projektor2_Model_SKurz[] array of Projektor2_Model_SKurz
     */
    protected function getContextSelectedDbSKurzModels($kurz_druh, $default=TRUE) { // TODO - přesunout do modelu
        $filter = "(projekt_kod='".$this->sessionStatus->projekt->kod
                ."' AND kancelar_kod='".$this->sessionStatus->kancelar->kod
                ."' AND beh_cislo='".$this->sessionStatus->beh->beh_cislo
                ."' AND kurz_druh='".$kurz_druh."')";
        if ($default) {
            $filter .= " OR kurz_zkratka='*'";
        }
        $filter = "(".$filter.")";
        $mapper = new Projektor2_Model_Db_SKurzMapper();
        return $mapper->findAll($filter, 'razeni');
    }

    /**
     * Vytvoří asociativní pole polí Projektor2_Model_SKurz, první index je druh kurzu, druhý id SKurz.
     * Pole je použito ve formulářích IP
     *
     * @param type $aktivityProjektu
     * @return array[Projektor2_Model_SKurz[]] array of arrays of Projektor2_Model_SKurz
     */
    protected function createDbSKurzModelsAssoc($aktivityProjektu) {
        $DbSKurzModels = array();
        foreach ($aktivityProjektu as $indexAktivity => $parametryAktivity) {
            foreach ( $this->getContextSelectedDbSKurzModels($parametryAktivity['kurz_druh']) as $sKurz) {
                /** @var Projektor2_Model_Db_SKurz $sKurz */
                $DbSKurzModels[$indexAktivity][$sKurz->id] = $sKurz;
            }
        }
        return $DbSKurzModels;
    }

    protected function createFileName(Projektor2_Model_SessionStatus $sessionStatus, $file) {
        return $sessionStatus->projekt->kod.'_'.$file.' '.$sessionStatus->zajemce->identifikator.'.pdf';
    }
}
