<?php
class Projektor2_Viewmodel_ZajemceRegistraceMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky zajemce. Id modelu je shodné z id zajemce.
     * @param integer $id
     * @return Projektor2_Viewmodel_ZajemceRegistrace
     */
    public static function findById($id) {
        $zajemce = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findById($id);
        return self::create($zajemce);
    }

    public static function findAll($filter = NULL, $filterBindParams=array(), $order = NULL) {
        $zajemci = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findAll($filter, $filterBindParams, $order);
        if ($zajemci) {
            foreach ($zajemci as $zajemce) {
                $zajemciRegistrace[] = self::create($zajemce);
            }
        } else {
            return array();
        }
        return $zajemciRegistrace;
    }

    public static function create(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $zajemceRegistrace =  new Projektor2_Viewmodel_ZajemceRegistrace($zajemceDbReadOsobniUdaje);
        // nastaví skupiny objeku zajemceRegistrace
        return Config_MenuOsoba::setSkupinyZajemce($zajemceRegistrace, $zajemceDbReadOsobniUdaje->zajemce);
    }

    ######### PRIVATE #######################

}
