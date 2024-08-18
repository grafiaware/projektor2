<?php
/**
 * Description of Projektor2_Controller_Formular_HelpIP
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_IP extends Projektor2_Controller_Formular_FlatTable {

    /**
     * Metoda vrací pole objektů Projektor2_Model_SKurz pro aktuální projekt, běh, kancelář a zadaný druh kurzu.
     * Metoda vytvoří filtr z kontextu aplikace
     * (projekt, běh a kancelář) a druhu kurzu zadaného jako parametr. Do výběru přidá vždy i kurzy,
     * kde kurz_zkratka='*'. S tímto filtrem pak volá Projektor2_Model_SKurzMapper, metodu findAll().
     *
     * @param string $kurz_druh Parametr musí obsahovat hodnotu ze sloupce kurz_druh db tabulky s_kurz
     * @param type $default TRUE - metoda vrací i model z tabulky s_kurz se zkratkou kurzu '*', tento model pak může být defaulní hodnotou v selectu
     * @return Projektor2_Viewmodel_KurzViewmodel[]
     */
    protected function findKurzViewmodelsInContext($kurz_druh, $default=TRUE) { // TODO - přesunout do modelu
        $filter = "(projekt_kod='".$this->sessionStatus->getUserStatus()->getProjekt()->kod
                ."' AND kancelar_kod='".$this->sessionStatus->getUserStatus()->getKancelar()->kod
//                ."' AND beh_cislo='".$this->sessionStatus->getUserStatus()->getBeh()->beh_cislo
                ."' AND kurz_druh='".$kurz_druh."')";
        if ($default) {
            $filter .= " OR kurz_zkratka='*'";
        }
        $filter = "(".$filter.")";
        return Projektor2_Viewmodel_KurzViewmodelMapper::find($filter, 'kurz_druh, kurz_cislo'); // 'razeni');
    }

    /**
     * Vytvoří asociativní pole polí Projektor2_Viewmodel_KurzViewmodel, první index je druh kurzu, druhý id SKurz.
     * Pole je použito ve formulářích IP
     *
     * @param array $aktivityProjektu
     * @return array[Projektor2_Viewmodel_KurzViewmodel[]] array of arrays of Projektor2_Viewmodel_KurzViewmodel
     */
    protected function createKurzViewodelsAssoc($aktivityProjektu) {
        $viewModels = array();
        foreach ($aktivityProjektu as $indexAktivity => $parametryAktivity) {
            foreach ( $this->findKurzViewmodelsInContext($parametryAktivity['kurz_druh']) as $viewmodelKurz) {
                /** @var Projektor2_Viewmodel_KurzViewmodel $viewmodelKurz */
                $viewModels[$indexAktivity][$viewmodelKurz->id] = $viewmodelKurz;

            }
        }
        return $viewModels;
    }

    protected function createFileName(Projektor2_Model_Status $sessionStatus, $file) {
        return $sessionStatus->getUserStatus()->getProjekt()->kod.'_'.$file.' '.$sessionStatus->getUserStatus()->getZajemce()->identifikator.'.pdf';
    }
}
