<?php
/**
 * Description of Projektor2_Controller_Element_MenuFormulare
 *
 * @author pes2704
 */
class Projektor2_Controller_Element_MenuKurz extends Projektor2_Controller_Abstract {

    const VIEWMODEL_KURZ = 'viewmodel_kurz';
    const HTML_SKUPINY = 'htmlSkupiny';

    /**
     * 
     * @return \Projektor2_View_HTML_Element_Div
     */
    public function getResult() {
        //nové
        $htmlParts = array();
        if (isset($this->params[self::VIEWMODEL_KURZ])) {
            $kurzViewmodel = $this->params[self::VIEWMODEL_KURZ];
            // sada td tlačítka
            $skupinaController = new Projektor2_Controller_Element_MenuKurzy_Skupina($this->sessionStatus, $this->request, $this->response,
                    [Projektor2_Controller_Element_MenuKurzy_Skupina::VIEWMODEL_KURZ=>$kurzViewmodel]);
            $htmlSkupiny = $skupinaController->getResult();
            // tr - registrační údaje + sada tlačítek + sada signálů
            $viewRegistrace = new Projektor2_View_HTML_Element_Kurz_Info(
                    $this->sessionStatus,
                    [Projektor2_View_HTML_Element_Kurz_Info::VIEWMODEL_KURZ=>$kurzViewmodel, Projektor2_View_HTML_Element_Kurz_Info::HTML_SKUPINY=>$htmlSkupiny]
                );
            $htmlParts[] = $viewRegistrace;
        }
        return new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$htmlParts));
    }
}
