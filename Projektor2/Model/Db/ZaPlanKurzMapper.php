<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZaPlanKurzMapper
 *
 * @author pes2704
 */
class Projektor2_Model_Db_ZaPlanKurzMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM za_plan_kurz WHERE id_za_plan_kurz = :id_za_plan_kurz";
        $bindParams = array('id_za_plan_kurz'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return self::create($data);
    }

    /**
     * Vytvoří pole objektů Projektor2_Model_Db_ZaPlanKurz z dat vybraných pro jednoho zájemce.
     *
     * @param int $id_zajemce
     * @param int $minimalIdSKurz Default 3 - zařazen (naplánován) konkrétní kurz
     * @return Projektor2_Model_Db_ZaPlanKurz[] Pole objektů Projektor2_Model_Db_ZaPlanKurz
     */
    public static function findAllForZajemce($id_zajemce, $minimalIdSKurz = 3) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM za_plan_kurz WHERE id_zajemce=:id_zajemce AND id_s_kurz_FK>:minimal_id_s_kurz_FK ORDER BY kurz_druh_fk ASC, aktivita ASC";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':id_zajemce', $id_zajemce);
        $sth->bindValue('minimal_id_s_kurz_FK', $minimalIdSKurz);
        $succ = $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows) {
            return array();
        }
        foreach($rows as $data) {
            $vypis[] = self::create($data);
        }
        return $vypis;
    }

    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM za_plan_kurz";
        if ($filter AND is_string($filter)) {
            $query .= " WHERE ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }

        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows) {
            return array();
        }
        foreach($rows as $data) {
            $vypis[] = self::create($data);
        }
        return $vypis;
    }

    private static function create($data) {
        return new Projektor2_Model_Db_ZaPlanKurz(
            $data['id_za_plan_kurz'],
            $data['id_zajemce'],
            $data['id_s_kurz_FK'],
            $data['kurz_druh_fk'],
            $data['aktivita'],
            $data['text'],
            $data['poc_abs_hodin'],
            $data['duvod_absence'],
            $data['dokonceno'],
            $data['duvod_neukonceni'],
            $data['datum_certif']
        );
    }
}
