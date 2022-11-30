<?php
class Projektor2_Viewmodel_OsobaMenuViewmodelMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky zajemce. Id modelu je shodné z id zajemce.
     * @param integer $id
     * @return Projektor2_Viewmodel_OsobaMenuViewmodel
     */
    public static function findById($id) {
        $zajemce = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findById($id);
        return self::create($zajemce);
    }

    public static function find($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE) {
        $zajemci = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::find($filter, $filterBindParams, $order, $findInvalid);
        if ($zajemci) {
            foreach ($zajemci as $zajemce) {
                $zajemciRegistrace[] = self::create($zajemce);
            }
        } else {
            return array();
        }
        return $zajemciRegistrace;
    }

    public static function findInContext($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $zajemci = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findInContext($filter, $filterBindParams, $order, $findInvalid, $findOutOfContext);
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
        $zajemceRegistrace =  new Projektor2_Viewmodel_OsobaMenuViewmodel($zajemceDbReadOsobniUdaje);
        // nastaví skupiny objeku zajemceRegistrace
        return Config_MenuOsoba::setSkupinyZajemce($zajemceRegistrace, $zajemceDbReadOsobniUdaje->zajemce);
    }

    ######### PRIVATE #######################

}
