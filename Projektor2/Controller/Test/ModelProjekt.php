<?php
/**
 * Test třídy Projektor2_Controller_Test_ModelProjekt a Projektor2_Model_ProjektMapper
 * volání testu (cestu je třeba upravit podla aktuálního adresáře projektu - např. p2_1_4):
 * http://localhost/p2_1_4/index.php?akce=test&testclass=Projektor2_Controller_Test_ModelProjekt
 * @author pes2704
 */
class Projektor2_Controller_Test_ModelProjekt extends Projektor2_Controller_Abstract {

    public function getResult() {
        $projekt = Projektor2_Model_Db_ProjektMapper::findByKod($this->sessionStatus->projekt->kod);
        $html = '<div class=test>';
        $html .= '<h1>Test Projektor2_Model_ProjektMapper a Projektor2_Model_Projekt';
        $html .= '<pre>'.print_r($projekt, TRUE).'</pre>';
        $html .= '<pre>'.print_r($projekt->getNames(), TRUE).'</pre>';
        $html .= '<pre>'.print_r($projekt->getValues(), TRUE).'</pre>';
        $html .= '<pre>'.print_r($projekt->getValuesAssoc(), TRUE).'</pre>';
        $html .= '</div>';
        return $html;
    }
}
