<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Signal_Ukonceni extends Projektor2_Viewmodel_Menu_Signal {

    public function setByUkonceni(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {

        if ($zajemceDbReadOsobniUdaje->datum_ukonceni){
            $duvod = $zajemceDbReadOsobniUdaje->duvod_ukonceni;
            $this->text = substr($duvod, 0, strpos($duvod, ' '));
            if ($zajemceDbReadOsobniUdaje->dokonceno=='Ano' AND $zajemceDbReadOsobniUdaje->datum_certif) {  //ma certifikat projekt
                $this->status = 'uspesneSCertifikatem';
            } elseif ($zajemceDbReadOsobniUdaje->dokonceno=='Ano') {
                $this->status = 'uspesne';
            } elseif ($zajemceDbReadOsobniUdaje->dokonceno=='Ne') {
                $this->status = 'neuspesne';
            } elseif ($zajemceDbReadOsobniUdaje->duvod_ukonceni) {
                $this->status = 'ukonceni';
            } else {
                $this->status = 'none';
            }
        } else {
            $this->text = '.';
            $this->status = 'none';
        }
    }
}
