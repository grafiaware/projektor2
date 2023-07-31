<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamUcastnikuKurzu extends Projektor2_Controller_Abstract {
    private function getLeftMenuArray() {
        $lastGetRequest = $this->sessionStatus->getLastGet();
        $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=seznam', 'text'=>'Zpět na výběr kurzu'];
        return $menuArray;
    }

    private function getLeftMenuArrayUcastnici() {
//        if ( ($this->sessionStatus->getUserStatus()->getUser()->username == "sys_admin" OR $this->sessionStatus->getUserStatus()->getUser()->username == "cj_manager" OR $this->sessionStatus->getUserStatus()->getUser()->username == "cj_monitor")) {
            $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=kurz&kurz=excel', 'text'=>'Exporty dat'];
            $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=kurz&kurz=export_certifikaty_kurz', 'text'=>'Exportuj certifikáty za kurz'];
//        }
        return $menuArray;
    }

    public function getResult() {

        $gridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);

        // jednořádková tabulka s kurzem - nezobrazuje se pro nový kurz
        $viewmodelKurz = (new Projektor2_Viewmodel_KurzViewmodelMapper())->get($this->sessionStatus->getUserStatus()->getSKurz()->id_s_kurz);
        $params = [Projektor2_Controller_Element_MenuKurz::VIEWMODEL_KURZ => $viewmodelKurz];
        $tlacitkaController = new Projektor2_Controller_Element_MenuKurz($this->sessionStatus, $this->request, $this->response, $params);
        $rowsKurzy[] = $tlacitkaController->getResult();
        $tableKurzy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rowsKurzy, 'class'=>'zaznamy']);
        $contentParts[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$tableKurzy, 'class'=>'content']);

        $zaPlanKurzArray = Projektor2_Model_Db_ZaPlanKurzMapper::findByFilter("za_plan_kurz.id_s_kurz_FK={$this->sessionStatus->getUserStatus()->getSKurz()->id_s_kurz}");
        if ($zaPlanKurzArray) {
            $subgridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArrayUcastnici()]);

            $inBinds = [];
            $i = 0;
            foreach ($zaPlanKurzArray as $zaPlanKurz) {
                $inBinds[':in'.$i++] = $zaPlanKurz->id_zajemce;
            }
            $inPlaceholders = implode(", ", array_keys($inBinds));

            // hledání bez kontextu (projekt, kancelář, běh) - rozhodující jsou id zájemců (podle Projektor2_Model_Db_ZaPlanKurzMapper)
            // a valid - hodnotu valid zohledňuje i metoda find()
            $osobyMenu = Projektor2_Viewmodel_OsobaMenuViewmodelMapper::find("zajemce.id_zajemce IN ($inPlaceholders)", $inBinds, "identifikator");
            $subgridColumn[] = (string) (new Projektor2_Controller_Element_TabulkaMenuOsoby($this->sessionStatus, $this->request, $this->response, $osobyMenu))->getResult();
            $contentParts[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$subgridColumn, 'class'=>'grid-container']);
        }
        $gridColumn[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$contentParts, 'class'=>'content']);

        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$gridColumn, 'class'=>'grid-container']);
        return $viewZobrazeniRegistraci;
    }
}

