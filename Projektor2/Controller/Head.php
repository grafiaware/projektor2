<?php
/**
 * Description of Head
 *
 * @author pes2704
 */
class Projektor2_Controller_Head extends Projektor2_Controller_Abstract {

    public function getResult() {
        return new Projektor2_View_HTML_Head($this->sessionStatus);
    }
}