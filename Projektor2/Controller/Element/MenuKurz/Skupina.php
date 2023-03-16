<?php
/**
 * Description of Tlacitka
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuKurz_Skupina extends Projektor2_Controller_Abstract {

    const VIEWMODEL_KURZ = 'viewmodelKurz';
    const ID_ZAJEMCE = 'id_zajemce';

     public function getResult() {
         /** @var Projektor2_Viewmodel_OsobaMenuViewmodel $viewmodelKurz */
        $viewmodelKurz = $this->params[self::VIEWMODEL_KURZ];
        $html = '';
        foreach ($viewmodelKurz->getGroups() as $skupina) {
            foreach ($skupina->getButtons() as $tlacitko) {
                $view = new Projektor2_View_HTML_Element_Kurz_TdTlacitko($this->sessionStatus);
                $view->appendContext([
                            Projektor2_View_HTML_Element_Kurz_TdTlacitko::VIEWMODEL_TLACITKO=>$tlacitko,
                            Projektor2_View_HTML_Element_Kurz_TdTlacitko::ID_KURZ=>$viewmodelKurz->id
                        ]);
                $html .= $view->render();
            }
            foreach ($skupina->getSignals() as $signal) {
                $view = new Projektor2_View_HTML_Element_Kurz_TdSignal($this->sessionStatus);
                $view->appendContext(array('model'=>$signal));
                $html .= $view->render();
            }
        }
        return $html;
     }
}
