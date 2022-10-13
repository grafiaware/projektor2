<?php
/**
 * Description of Tlacitka
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuFormulare_Skupina extends Projektor2_Controller_Abstract {

     public function getResult() {
         /** @var Projektor2_Viewmodel_ZajemceRegistrace $zajemceRegistrace */
        $zajemceRegistrace = $this->params['zajemceRegistrace'];
        $html = '';
        foreach ($zajemceRegistrace->getSkupinyAssoc() as $skupina) {
            foreach ($skupina->getMenuTlacitkaAssoc() as $tlacitko) {
                $view = new Projektor2_View_HTML_Element_Zajemce_TdTlacitko($this->sessionStatus);
                $view->appendContext(array('model'=>$tlacitko, 'zajemceRegistrace'=>$zajemceRegistrace));
                $html .= $view->render();
            }
            foreach ($skupina->getMenuSignalyAssoc() as $signal) {
                $view = new Projektor2_View_HTML_Element_Zajemce_TdSignal($this->sessionStatus);
                $view->appendContext(array('model'=>$signal));
                $html .= $view->render();
            }
        }
        return $html;
     }
}
