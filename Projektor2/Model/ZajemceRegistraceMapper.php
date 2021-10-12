<?php
class Projektor2_Model_ZajemceRegistraceMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky zajemce. Id modelu je shodné z id zajemce.
     * @param integer $id
     * @return Projektor2_Model_ZajemceRegistrace
     */
    public static function findById($id) {
        $zajemce = Projektor2_Model_ZajemceOsobniUdajeMapper::findById($id);
        return self::create($zajemce);
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $zajemci = Projektor2_Model_ZajemceRegistraceMapper::findAll($filter, $order);
        if ($zajemci) {
            foreach ($zajemci as $zajemce) {
                $zajemciRegistrace[] = self::create($zajemce);
            }
        } else {
            return array();
        }
        return $zajemciRegistrace;
    }
    
    public static function create(Projektor2_Model_ZajemceOsobniUdaje $zajemceOsobniUdaje) {
        $zajemceRegistrace =  new Projektor2_Model_ZajemceRegistrace($zajemceOsobniUdaje->jmenoCele(), $zajemceOsobniUdaje->zajemce->identifikator, $zajemceOsobniUdaje->zajemce->znacka, $zajemceOsobniUdaje->zajemce->id);   
        // nastaví skupiny objeku zajemceRegistrace
        return Projektor2_AppContext::setSkupiny($zajemceRegistrace, $zajemceOsobniUdaje->zajemce);
    }

    ######### PRIVATE #######################

}
