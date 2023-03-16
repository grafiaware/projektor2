<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Signal_OsobniUdaje extends Projektor2_Viewmodel_Menu_Signal {

    public function setByOsobaMenuViewmodel(Projektor2_Viewmodel_OsobaMenuViewmodel $osobaMenuViewmodel) {
        $this->mobil = $osobaMenuViewmodel->mobil;
        $this->email = $osobaMenuViewmodel->mail;
        $this->datumNarozeni = $osobaMenuViewmodel->datum_narozeni;
        
    }
}
