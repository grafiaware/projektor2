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
    
    private static $sql="
SELECT `za_plan_kurz`.`id_za_plan_kurz`,
    `za_plan_kurz`.`id_zajemce`,
    `za_plan_kurz`.`id_s_kurz_FK`,
    `za_plan_kurz`.`kurz_druh_fk`,
    `za_plan_kurz`.`aktivita`,
    `za_plan_kurz`.`text`,
    `za_plan_kurz`.`poc_abs_hodin`,
    `za_plan_kurz`.`poc_abs_hodin_distancne`,
    `za_plan_kurz`.`poc_abs_hodin_praxe`,
    `za_plan_kurz`.`duvod_absence`,
    `za_plan_kurz`.`dokonceno`,
    `za_plan_kurz`.`duvod_neukonceni`,
    `za_plan_kurz`.`date_certif`,
    `za_plan_kurz`.`date_zacatek_extra`,
    `za_plan_kurz`.`date_konec_extra`,
    `za_plan_kurz`.`date_zaverecna_zkouska_extra`
FROM `za_plan_kurz`";

    private static $statementfindAllForZajemce;
    /**
     *
     * @param int $id
     * @return Projektor2_Model_Db_ZaPlanKurz
     */
    public static function get($id) {
        $dbh = Config_AppContext::getDb();
        $query = self::$sql . "WHERE id_za_plan_kurz = :id_za_plan_kurz";
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
        $dbh = Config_AppContext::getDb();
//        $query = "SELECT * FROM za_plan_kurz WHERE id_zajemce=:id_zajemce AND id_s_kurz_FK>:minimal_id_s_kurz_FK ORDER BY kurz_druh_fk ASC, aktivita ASC";

        if (!isset(self::$statementfindAllForZajemce)) {
        $query = self::$sql . "
WHERE
za_plan_kurz.id_zajemce=:id_zajemce 
AND 
za_plan_kurz.id_s_kurz_FK>:minimal_id_s_kurz_FK 
ORDER BY kurz_druh_fk ASC, aktivita ASC";            
            self::$statementfindAllForZajemce = $dbh->prepare($query);
        }
        $sth = self::$statementfindAllForZajemce;
        $sth->bindValue('id_zajemce', $id_zajemce);
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

    /**
     *
     * @param string $filter
     * @param string $order
     * @return Projektor2_Model_Db_ZaPlanKurz[]
     */
    public static function findByFilter($filter = NULL, $order = NULL) {
        $dbh = Config_AppContext::getDb();
        $query = self::$sql;
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
            $data['poc_abs_hodin_distancne'],
            $data['poc_abs_hodin_praxe'],
            $data['duvod_absence'],
            $data['dokonceno'],
            $data['duvod_neukonceni'],
            $data['date_certif'],
            $data['date_zacatek_extra'],
            $data['date_konec_extra'],
            $data['date_zaverecna_zkouska_extra']                
        );
    }
}
