<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hlavicka
 *
 * @author pes2704
 */
class Projektor2_Controller_Logo extends Projektor2_Controller_Abstract {

    public function getResult() {
        $context = Config_AppContext::getLogoContext($this->sessionStatus);
        $view = new Projektor2_View_HTML_Logo($this->sessionStatus, $context);
        $html = $view->render();
        return $html;
    }
}

