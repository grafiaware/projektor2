<?php
class Projektor2_Viewmodel_KurzMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky zajemce. Id modelu je shodné z id zajemce.
     * @param integer $id
     * @return Projektor2_Viewmodel_Kurz
     */
    public static function get($id) {
        $sKurz = Projektor2_Model_Db_SKurzMapper::get($id);
        return self::create($sKurz);
    }

    /**
     *
     * @param type $filter
     * @param type $order
     * @return Projektor2_Viewmodel_Kurz[]
     */
    public static function find($filter = NULL, $order = NULL) {
        $kurzy = Projektor2_Model_Db_SKurzMapper::find($filter, $order);
        foreach ($kurzy as $kurz) {
            $kurzViewmodel[] = self::create($kurz);
        }
        return $kurzViewmodel ?? [];
    }

    /**
     *
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return Projektor2_Viewmodel_Kurz
     */
    private static function create(Projektor2_Model_Db_SKurz $sKurz) {
        $viewmodelKurz =  new Projektor2_Viewmodel_Kurz($sKurz);
        // nastaví skupiny objeku zajemceRegistrace
        return Projektor2_AppContext::setSkupinyKurz($viewmodelKurz, $sKurz);
    }

    ######### PRIVATE #######################

}
