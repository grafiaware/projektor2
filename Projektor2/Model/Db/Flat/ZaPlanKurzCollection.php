<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZaPlanKurzCollection
 *
 * @author pes2704
 */
class Projektor2_Model_Db_Flat_ZaPlanKurzCollection extends Framework_Model_CollectionFlatTable {

    public function __construct(Projektor2_Model_Db_Zajemce $zajemce){
        parent::__construct("za_plan_kurz",$zajemce);
    }

    protected function createItem(Projektor2_Model_Db_Zajemce $zajemce) {
        return new Projektor2_Model_Db_Flat_ZaPlanKurz($zajemce);
    }

    protected function provideCollectionKey($row) {
        return (string) $row['kurz_typ_fk'].$row['poradi'];
    }
}
