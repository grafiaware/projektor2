<?php
class Projektor2_Viewmodel_KurzViewmodelMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky s_kurz. Id modelu je shodné z id s_kurz.
     * @param integer $id
     * @return Projektor2_Viewmodel_KurzViewmodel
     */
    public static function get($id) {
        $sKurz = Projektor2_Model_Db_SKurzMapper::get($id);
        return self::create($sKurz);
    }

    /**
     *
     * @param type $filter
     * @param type $order
     * @return Projektor2_Viewmodel_KurzViewmodel[]
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
     * @return Projektor2_Viewmodel_KurzViewmodel
     */
    private static function create(Projektor2_Model_Db_SKurz $sKurz) {
        $viewmodelKurz =  new Projektor2_Viewmodel_KurzViewmodel($sKurz);
        // nastaví skupiny objeku zajemceRegistrace
        return Config_MenuKurz::setSkupinyKurz($viewmodelKurz, $sKurz);
    }

    ######### PRIVATE #######################

}
