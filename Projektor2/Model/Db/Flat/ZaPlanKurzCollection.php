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

    const COLLECTION_KEY_ATTRIBUTE = ['aktivita'];

    public function __construct(Projektor2_Model_Db_Zajemce $zajemce){
        parent::__construct("za_plan_kurz",$zajemce);
    }

    /**
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Model_Db_Flat_ZaPlanKurz
     */
    protected function createItem(Projektor2_Model_Db_Zajemce $zajemce) {
        return new Projektor2_Model_Db_Flat_ZaPlanKurz($zajemce);
    }

    protected function provideCollectionKey($row) {
        return implode("", array_intersect_key($row, array_flip(static::COLLECTION_KEY_ATTRIBUTE)));
    }

    protected function hydrateKeyAttributes($item, $row) {
        foreach (static::COLLECTION_KEY_ATTRIBUTE as $field) {
            $item->$field = $row[$field];
        }
    }
}
