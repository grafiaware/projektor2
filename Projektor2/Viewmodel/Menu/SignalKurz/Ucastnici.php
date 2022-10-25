<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_SignalKurz_Ucastnici extends Projektor2_Viewmodel_Menu_Signal {

    public function setByPlanKurzArray(array $zaPlanKurzArray) {
        $c = count($zaPlanKurzArray);
        if ($c){  //kurz má účastníky
            $this->text = (string) $c;
//                    $sKurz->kurz_druh;
            $this->status = 'planovaniUcastnici';
        } else {
            $this->text = '.';
            $this->status = 'none';
        }
    }
}
