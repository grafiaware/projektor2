<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamUcastnikuKurzu extends Projektor2_Controller_Abstract {
    private function getLeftMenuArray() {
        $menuArray[] = ['href'=>'index.php?akce=kurzy', 'text'=>'Zpět na výběr kurzu'];
        return $menuArray;
    }

    private function getLeftMenuArrayUcastnici() {
//        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "cj_manager" OR $this->sessionStatus->user->username == "cj_monitor")) {
            $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=kurz&kurz=export_ucastnici', 'text'=>'Exportuj přehled'];
//        }
        return $menuArray;
    }

    public function getResult() {

        $gridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);

        // jednořádková tabulka s kurzem - nezobrazuje se pro nový kurz
        $viewmodelKurz = (new Projektor2_Viewmodel_KurzMapper())->get($this->sessionStatus->sKurz->id_s_kurz);
        $params = [Projektor2_Controller_Element_MenuKurz::VIEWMODEL_KURZ => $viewmodelKurz];
        $tlacitkaController = new Projektor2_Controller_Element_MenuKurz($this->sessionStatus, $this->request, $this->response, $params);
        $rowsKurzy[] = $tlacitkaController->getResult();
        $tableKurzy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rowsKurzy, 'class'=>'zaznamy']);
        $contentParts[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$tableKurzy, 'class'=>'content']);

        $zaPlanKurzArray = Projektor2_Model_Db_ZaPlanKurzMapper::findAll("id_s_kurz_FK={$this->sessionStatus->sKurz->id_s_kurz}");
        if ($zaPlanKurzArray) {
            $inBinds = [];
            $i = 0;
            foreach ($zaPlanKurzArray as $zaPlanKurz) {
                $inBinds[':in'.$i++] = $zaPlanKurz->id_zajemce;
            }
            $inPlaceholders = implode(", ", array_keys($inBinds));
            $ucastniciRegistrace = Projektor2_Viewmodel_ZajemceRegistraceMapper::findAll("zajemce.id_zajemce IN ($inPlaceholders)", $inBinds, "identifikator");
            foreach ($ucastniciRegistrace as $ucastnikRegistrace) {
                $params = ['zajemceRegistrace' => $ucastnikRegistrace];
                $tlacitkaController = new Projektor2_Controller_Element_MenuZajemce($this->sessionStatus, $this->request, $this->response, $params);
                $rowsUcastnici[] = $tlacitkaController->getResult();
            }

            $subgridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArrayUcastnici()]);
            $seznam[] =  new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rowsUcastnici, 'class'=>'zaznamy']);
            $subgridColumn[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$seznam, 'class'=>'content']);
        }
        $contentParts[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$subgridColumn, 'class'=>'grid-container']);
        $gridColumn[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$contentParts, 'class'=>'content']);

        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$gridColumn, 'class'=>'grid-container']);
        return $viewZobrazeniRegistraci;
    }
}

