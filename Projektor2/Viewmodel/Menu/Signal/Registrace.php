<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Signal_Registrace extends Projektor2_Viewmodel_Menu_Signal {

    public function setByDbReadOsobniUdaje(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $required = ['prijmeni', 'jmeno', 'datum_narozeni', 'mobilni_telefon', 'mail'];
        $ok = true;
        foreach ($required as $prop) {
            $ok = $ok && isset($zajemceDbReadOsobniUdaje->$prop) && $zajemceDbReadOsobniUdaje->$prop;
        }
        if ($ok) {
            $this->text = 'OK';
            $this->status = 'registrace ok';
        } else {
            $this->text = ($zajemceDbReadOsobniUdaje->datum_narozeni ? '*' : '').' '.($zajemceDbReadOsobniUdaje->mobilni_telefon ? 'T' : '').' '.($zajemceDbReadOsobniUdaje->mail ? '@' : '');
            $this->status = 'registrace chyba';
        }
    }
}
