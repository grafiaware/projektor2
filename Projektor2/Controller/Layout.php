<?php
/**
 * Description of Projektor2_Controller_Layout
 *
 * @author pes2704
 */
class Projektor2_Controller_Layout extends Projektor2_Controller_Abstract {

    public function getResult() {
        // kontrolery do šablony stránky - volají se vždy
        $headerController = new Projektor2_Controller_Header($this->sessionStatus, $this->request, $this->response);
        $vyberKontextController = new Projektor2_Controller_VyberKontext($this->sessionStatus, $this->request, $this->response);
        $footerController = new Projektor2_Controller_Footer($this->sessionStatus, $this->request, $this->response);

        $parts[] = $headerController->getResult();
        $parts[] = $vyberKontextController->getResult();;
        $parts[] = $footerController->getResult();

        $view = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts));
        $html = $view;
        return $html;
    }
}
