<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamRegistraci extends Projektor2_Controller_Abstract {

    protected function getLeftMenuArray() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        $menuArray[] = ['href'=>'index.php?osoby=excel', 'text'=>'Exporty dat'];
        $menuArray[] = ['href'=>'index.php?osoby=export_certifikaty_kurz', 'text'=>'Exportuj IP certifikáty'];
        $menuArray[] = ['href'=>'index.php?osoby=export_certifikaty_projekt', 'text'=>'Exportuj projektové certifikáty'];
        return $menuArray;
    }

###################
    public function getResult() {
        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);
        $parts[] = $viewLeftMenu;
        $startTime = microtime(true);
        $zajemciRegistrace = Projektor2_Viewmodel_ZajemceRegistraceMapper::findAll(NULL, NULL, "identifikator");
        $timeDb = (microtime(true)-$startTime) * 1000;
        if ($zajemciRegistrace) {
            foreach ($zajemciRegistrace as $zajemceRegistrace) {
                $tlacitkaController = new Projektor2_Controller_Element_MenuZajemce($this->sessionStatus, $this->request, $this->response, $zajemceRegistrace);
                $rows[] = $tlacitkaController->getResult();
            }
            $viewZaznamy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rows, 'class'=>'zaznamy']);
            $viewContent = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$viewZaznamy, 'class'=>'content']);
            $parts[] = $viewContent;
        }
        $timeControllers = (microtime(true)-$startTime) * 1000;

        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$parts, 'class'=>'grid-container']);
        $html = (string) $viewZobrazeniRegistraci;
        $timeRender = (microtime(true)-$startTime) * 1000;
        header('X-Projektor-TimeDb:' . sprintf('%2.3fms', $timeDb));
        header('X-Projektor-TimeCtrl:' . sprintf('%2.3fms', $timeControllers));
        header('X-Projektor-TimeRender:' . sprintf('%2.3fms', $timeRender));
        return $viewZobrazeniRegistraci;
    }
}

