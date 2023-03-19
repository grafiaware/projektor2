<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Signal_Registrace extends Projektor2_Viewmodel_Menu_Signal {

    public function setByDbReadOsobniUdaje(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        if ($this->isOk($zajemceDbReadOsobniUdaje)) {
            $this->text = 'OK';
            $this->status = 'registrace ok';
        } else {
            $this->text = 'X';
            $this->status = 'registrace chyba';            
        }        
    }
    
    private function isOk(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $required = ['prijmeni', 'jmeno', 'datum_narozeni', 'mobilni_telefon', 'mail'];
        $ok = true;
        foreach ($required as $prop) {
            $a = isset($zajemceDbReadOsobniUdaje->$prop);
            $b = $zajemceDbReadOsobniUdaje->$prop;
            $ok = $ok && isset($zajemceDbReadOsobniUdaje->$prop) && $zajemceDbReadOsobniUdaje->$prop;
        }
        return $ok;
    }
}
