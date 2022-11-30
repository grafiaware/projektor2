<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_FormularKurz extends Projektor2_Controller_Abstract {

    private function getLeftMenuArray() {
        $menuArray[] = ['href'=>'index.php?akce=kurzy', 'text'=>'Zpět na výběr kurzu'];
        return $menuArray;
    }

    public function getResult() {

        $gridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);

        // jednořádková tabulka s kurzem - nezobrazuje se pro nový kurz
        $viewmodelKurz = (new Projektor2_Viewmodel_KurzViewmodelMapper())->get($this->sessionStatus->sKurz->id_s_kurz);
        $params = [Projektor2_Controller_Element_MenuKurz::VIEWMODEL_KURZ => $viewmodelKurz];
        $tlacitkaController = new Projektor2_Controller_Element_MenuKurz($this->sessionStatus, $this->request, $this->response, $params);
        $rowsKurzy[] = $tlacitkaController->getResult();
        $tableKurzy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rowsKurzy, 'class'=>'zaznamy']);
        $contentParts[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$tableKurzy]);
        $contentParts[] = (new Projektor2_Controller_Formular_SKurz($this->sessionStatus, $this->request, $this->response))->getResult();
        $gridColumn[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$contentParts, 'class'=>'content']);

        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$gridColumn, 'class'=>'grid-container']);
        return $viewZobrazeniRegistraci;
    }
}

?>
