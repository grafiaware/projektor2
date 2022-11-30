<?php
/**
 * Description of Tlacitka
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuOsoba_Skupina extends Projektor2_Controller_Abstract {

     public function getResult() {
         /** @var Projektor2_Viewmodel_OsobaMenuViewmodel $zajemceRegistrace */
        $zajemceRegistrace = $this->params;
        $html = '';
        foreach ($zajemceRegistrace->getSkupinyAssoc() as $skupina) {
            foreach ($skupina->getMenuTlacitka() as $tlacitko) {
                $view = new Projektor2_View_HTML_Element_Zajemce_TdTlacitko($this->sessionStatus);
                $view->appendContext(array('model'=>$tlacitko, 'zajemceRegistrace'=>$zajemceRegistrace));
                $html .= $view->render();
            }
            foreach ($skupina->getMenuSignaly() as $signal) {
                $view = new Projektor2_View_HTML_Element_Zajemce_TdSignal($this->sessionStatus);
                $view->appendContext(array('model'=>$signal));
                $html .= $view->render();
            }
        }
        return $html;
     }
}