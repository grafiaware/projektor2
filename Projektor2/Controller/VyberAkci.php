<?php
/**
 * Description of Projektor2_Controller_VyberKontext
 *
 * @author pes2704
 */
class Projektor2_Controller_VyberAkci extends Projektor2_Controller_Abstract {

    public function getResult() {

        $part[] = (new Projektor2_View_HTML_VyberAkci($this->sessionStatus))->render();
        if ($this->request->get('akce')) {
            $part[] = (new Projektor2_Router_Akce($this->sessionStatus, $this->request, $this->response))->getController()->getResult();
        }
        return new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$part));
    }
}

