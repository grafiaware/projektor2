<?php
/**
 * Používá tabulku za_plan_flat_table
 */
class Projektor2_Model_Db_Flat_ZaPlanKurz extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Zajemce $zajemce){
        parent::__construct("za_plan_kurz",$zajemce);
    }

}