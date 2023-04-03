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
class Projektor2_Controller_ConnectionInfo extends Projektor2_Controller_Abstract {

    public function getResult() {
        $dbh = Config_AppContext::getDb();
            if (false AND $dbh->getDbHost() == 'localhost') {
                $html = '<div class="connection development">';
                $html .= 'Uživatel '.$this->sessionStatus->getUserStatus()->getUser()->username.' pracuje s databází '.
                    $dbh->getDbName().' na stroji '.$dbh->getDbHost().' jako '.$dbh->getUser().'.';
            } else {
                $html = '<div class="connection production">';
            }

            $html .= '     </div>';
        return $html;
    }
}

?>