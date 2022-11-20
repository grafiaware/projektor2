<?php
/**
 * Description of Projektor2_Controller_VyberKontext
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamKurzu extends Projektor2_Controller_Abstract {

    protected function createFormModels($zajemce) {
        // Položky kontextu, které budou použity v elementech formuláře pro zadání (výběr) hodnot uživatelem,
        // t.j. elementy input, textarea, select, checkbox, radiobutton.
        // Kontext je asociativní pole, indexy kontextu se ve formuláři použijí jako jména (name) proměnných formuláře a hodnoty kontextu jako hodnoty (value) proměnných formuláře.
        //
        $this->models[Projektor2_Controller_Formular_FlatTable::PLAN_FT] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT] = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
        $this->models[Projektor2_Controller_Formular_FlatTable::PLAN_KURZ] = new Projektor2_Model_Db_Flat_ZaPlanKurzCollection($zajemce);
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
            foreach ( $this->findKurzViewmodels($parametryAktivity['kurz_druh']) as $sKurz) {
                /** @var Projektor2_Model_Db_SKurz $sKurz */
                $DbSKurzModels[$indexAktivity][$sKurz->id_s_kurz] = $sKurz;
            }
        }
        return $DbSKurzModels;
    }

    /**
     * Metoda vrací pole objektů Projektor2_Model_Kurz pro aktuální projekt, běh, kancelář a zadaný druh kurzu.
     * Metoda vytvoří filtr z kontextu aplikace (projekt, běh a kancelář) a druhu kurzu zadaného jako parametr.
     * S tímto filtrem pak volá Projektor2_Model_KurzMapper, metodu findAll().
     *
     * @return Projektor2_Viewmodel_Kurz[] array of Projektor2_Model_Kurz
     */
    protected function findKurzViewmodels() {
        $filter = "(projekt_kod='{$this->sessionStatus->projekt->kod}'
                 AND kancelar_kod='{$this->sessionStatus->kancelar->kod}'
                                          )";

//                 AND beh_cislo='{$this->sessionStatus->beh->beh_cislo}'
        //                 AND kurz_druh='$kurz_druh'
        $mapper = new Projektor2_Viewmodel_KurzMapper();
        return $mapper->find($filter, 'razeni');
    }

    protected function getLeftMenuArray() {
        if ( ($this->sessionStatus->user->username == "sys_admin")) {
            $menuArray[] = ['href'=>'index.php?kurzy=form&form=cj_novy_kurz&novy_kurz', 'text'=>'Nový kurz'];
        }
        $menuArray[] = ['href'=>'index.php?kurzy=excel', 'text'=>'Exporty dat'];

        return $menuArray;
    }

    public function getResult() {
        $viewmodelyKurzu = $this->findKurzViewmodels();

        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, array('menuArray'=>$this->getLeftMenuArray()));
        $parts[] = $viewLeftMenu;

        if ($viewmodelyKurzu) {
            foreach ($viewmodelyKurzu as $viewmodelKurz) {
                $params = [Projektor2_Controller_Element_MenuKurz::VIEWMODEL_KURZ => $viewmodelKurz];
                $tlacitkaController = new Projektor2_Controller_Element_MenuKurz($this->sessionStatus, $this->request, $this->response, $params);
                $rows[] = $tlacitkaController->getResult();
            }
            $viewZaznamy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, array('rows'=>$rows, 'class'=>'zaznamy'));
            $viewContent = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>array($viewZaznamy), 'class'=>'content'));
            $parts[] = $viewContent;
        }
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts, 'class'=>'grid-container'));
        return $viewZobrazeniRegistraci;
    }
}

