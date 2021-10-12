<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Model_Menu_Signal_Zamestnani extends Projektor2_Model_Menu_Signal {
    
    public function setByZamestnani(Projektor2_Model_Db_Flat_ZaZamFlatTable $zamestnani) {
        
        if ($zamestnani->zam_datum_vstupu) {
            $forma = $zamestnani->zam_forma;
            switch ($forma) {
                case 'pracovní smlouva':
                    $this->text = 'PP';
                    break;
                case 'dohoda o pracovní činnosti':
                    $this->text = 'DPČ';
                    break;
                case 'dohoda o provedení práce':
                    $this->text = 'DPP';
                    break;                
                case 'sebezaměstnání (OSVČ)':
                    $this->text = 'OSVČ';
                    break;                
                default:
                    break;
            }
            if ($zamestnani->zam_nove_misto=='Ano') {
                $this->status = 'zamestnanNoveMisto';
            } elseif ($zamestnani->supm=='Ano') { 
                $this->status = 'zamestnanSUPM';                        
            } elseif ($this->text == 'PP' OR $this->text == 'OSVČ') {
                $this->status = 'zamestnan';                        
            } elseif ($zamestnani->zam_navazujici_datum_vstupu) {
                $this->status = 'zamestnanNavazujici';                        
            } else {
                $this->status = 'nezamestnan';                                        
            }
        } else {
            $this->text = '.';
            $this->status = 'none';                                        
        }        
    }
}
