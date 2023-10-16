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
     * Metoda vrací pole objektů Projektor2_Model_Kurz pro aktuální projekt, běh, kancelář a zadaný druh kurzu.
     * Metoda vytvoří filtr z kontextu aplikace (projekt, běh a kancelář) a druhu kurzu zadaného jako parametr.
     * S tímto filtrem pak volá Projektor2_Model_KurzMapper, metodu findAll().
     *
     * @return Projektor2_Viewmodel_KurzViewmodel[] array of Projektor2_Model_Kurz
     */
    protected function findKurzViewmodels($multilikeText=null, $multilikeDate=null) {
        $filter[] = "projekt_kod='{$this->sessionStatus->getUserStatus()->getProjekt()->kod}'";
        $filter[] = "kancelar_kod='{$this->sessionStatus->getUserStatus()->getKancelar()->kod}'";
        if (isset($multilikeText) AND $multilikeText) {
            $filter[] = "(kurz_nazev LIKE '%$multilikeText%' OR info_cas_konani LIKE '%$multilikeText%' OR info_misto_konani LIKE '%$multilikeText%' OR info_lektor LIKE '%$multilikeText%')";
        }
        if (isset($multilikeDate) AND $multilikeDate) {
            $filter[] = "(date_zacatek = '$multilikeDate' OR date_konec = '$multilikeDate' )";
        }
//                 AND beh_cislo='{$this->sessionStatus->getUserStatus()->getBeh()->beh_cislo}'
        //                 AND kurz_druh='$kurz_druh'

        $f = "(".implode(" AND ", $filter).")";
        $mapper = new Projektor2_Viewmodel_KurzViewmodelMapper();
        return $mapper->find($f, 'kurz_druh, kurz_cislo');
//        return $mapper->find($f, 'razeni');
    }

    protected function getLeftMenuArray() {
        if ( ($this->sessionStatus->getUserStatus()->getUser()->username == "sys_admin")) {
//            $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=form&form=cj_novy_kurz&novy_kurz', 'text'=>'Nový kurz'];
        }
        $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=excel', 'text'=>'Exporty dat'];

        return $menuArray;
    }

    public function getResult() {

        $multilike1 = $this->request->post('multiliketext');
        $multilike2 = $this->request->post('multilikedate');
        $parts[] = new Projektor2_View_HTML_Multilike($this->sessionStatus,
                [
                'multilike_text'=>$multilike1,
                'multilike_date'=>$multilike2,
                'title_text'=>'Hledá text v názvu, místu konání a v lektorovi.',
                'title_date'=>'Hledá datum v datumech začátku a konce kurzu.',
                ]);

        $viewmodelyKurzu = $this->findKurzViewmodels($multilike1, $multilike2);
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


        $gridColumns[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);
        $gridColumns[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$parts, 'class'=>'content']);
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$gridColumns, 'class'=>'grid-container']);
        return $viewZobrazeniRegistraci;
    }
}

