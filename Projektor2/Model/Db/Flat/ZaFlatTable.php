<?php
class Projektor2_Model_Db_Flat_ZaFlatTable extends Framework_Model_ItemFlatTable {

    /**
     * @param Projektor2_Model_Db_Zajemce $zajemce
     */
    public function __construct(Projektor2_Model_Db_Zajemce $zajemce=NULL){
        parent::__construct("za_flat_table",$zajemce);
    }
}
