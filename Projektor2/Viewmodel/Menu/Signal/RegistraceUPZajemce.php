<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Signal_RegistraceUPZajemce extends Projektor2_Viewmodel_Menu_Signal {

    public function setByDbReadOsobniUdaje(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
//'registrace_zajemce', 'registrace_uchazec', 'rekvalifikace_zajemce', 'rekvalifikace_uchazec'
        $required = ['registrace_zajemce', 'rekvalifikace_zajemce'];
        $ok = true;
        foreach ($required as $prop) {
            $ok = $ok && isset($zajemceDbReadOsobniUdaje->$prop) && $zajemceDbReadOsobniUdaje->$prop;
        }
        if ($zajemceDbReadOsobniUdaje->rekvalifikace_zajemce) {
            $this->status = 'registrace ok';
        } else {
            $this->status = 'registrace chyba';
        }
        $this->text = ($zajemceDbReadOsobniUdaje->registrace_zajemce ? 'RZ' : '--').' '.($zajemceDbReadOsobniUdaje->rekvalifikace_zajemce ? 'SZ' : 'XX');
        
    }
}
