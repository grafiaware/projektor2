<?php
class Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper {
    /**
     *
     * @param type $id
     * @param type $findInvalid
     * @param type $findOutOfContext
     * @return \Projektor2_Model_Db_Read_ZajemceOsobniUdaje
     */
    public static function findById($id) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT zajemce.id_zajemce, zajemce.identifikator, zajemce.znacka,
                        za_flat_table.jmeno,
                        za_flat_table.prijmeni, za_flat_table.datum_narozeni, za_flat_table.rodne_cislo,
                        za_flat_table.pohlavi, za_flat_table.titul, za_flat_table.titul_za
                    FROM zajemce left join za_flat_table ON (zajemce.id_zajemce=za_flat_table.id_zajemce)";
        $where[] = "zajemce.id_zajemce = :id_zajemce";
        $bindParams = array('id_zajemce'=>$id);
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_Read_ZajemceOsobniUdaje(
                    $data['id_zajemce'], $data['identifikator'], $data['znacka'], 
                    $data['titul'], $data['titul_za'], $data['jmeno'], $data['prijmeni'], $data['rodne_cislo'], $data['datum_narozeni'], $data['pohlavi']
                );
    }

    /**
     *
     * @param type $filter
     * @param type $filterBindParams
     * @param type $order
     * @param type $findInvalid
     * @return \Projektor2_Model_Db_Read_ZajemceOsobniUdaje[]
     */
    public static function find($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT zajemce.id_zajemce, zajemce.identifikator, zajemce.znacka,
                        za_flat_table.jmeno,
                        za_flat_table.prijmeni, za_flat_table.datum_narozeni, za_flat_table.rodne_cislo,
                        za_flat_table.pohlavi, za_flat_table.titul, za_flat_table.titul_za
                    FROM zajemce left join za_flat_table ON (zajemce.id_zajemce=za_flat_table.id_zajemce)";
        $where = array();
        $bindParams = array();
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }
        if ($filter AND is_string($filter)) {
            $where[] = $filter;
            $bindParams = array_merge($bindParams, $filterBindParams);
        }
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }

        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$radky) {
            return array();
        }
        foreach($radky as $data) {
            $vypis[] = new Projektor2_Model_Db_Read_ZajemceOsobniUdaje(
                    $data['id_zajemce'], $data['identifikator'], $data['znacka'], 
                    $data['titul'], $data['titul_za'], $data['jmeno'], $data['prijmeni'], $data['rodne_cislo'], $data['datum_narozeni'], $data['pohlavi']
                );
        }

        return $vypis;
    }

    /**
     *
     * @param type $filter
     * @param type $filterBindParams
     * @param type $order
     * @param type $findInvalid
     * @param type $findOutOfContext
     * @return \Projektor2_Model_Db_Read_ZajemceOsobniUdaje[]
     */
    public static function findInContext($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Config_AppContext::getDb();
        $appStatus = Projektor2_Model_Status::getSessionStatus();
        $query = "SELECT zajemce.id_zajemce, zajemce.identifikator, zajemce.znacka,
                        za_flat_table.jmeno,
                        za_flat_table.prijmeni, za_flat_table.datum_narozeni, za_flat_table.rodne_cislo,
                        za_flat_table.pohlavi, za_flat_table.titul, za_flat_table.titul_za
                    FROM zajemce left join za_flat_table ON (zajemce.id_zajemce=za_flat_table.id_zajemce)";
        $where = array();
        $bindParams = array();
        if (!$findOutOfContext) {
            if (isset($appStatus->getUserStatus()->getProjekt()->id)) {
                $where[] = "id_c_projekt_FK = :id_c_projekt_FK";
                $bindParams = array_merge($bindParams, array('id_c_projekt_FK'=>$appStatus->getUserStatus()->getProjekt()->id));
            }
            if (isset($appStatus->getUserStatus()->getKancelar()->id)) {
                $where[] = "id_c_kancelar_FK = :id_c_kancelar_FK";
                $bindParams = array_merge($bindParams, array('id_c_kancelar_FK'=>$appStatus->getUserStatus()->getKancelar()->id));
            }
            if (isset($appStatus->getUserStatus()->getBeh()->id)) {
                $where[] = "id_s_beh_projektu_FK = :id_s_beh_projektu_FK";
                $bindParams = array_merge($bindParams, array('id_s_beh_projektu_FK'=>$appStatus->getUserStatus()->getBeh()->id));
            }
        }
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }
        if ($filter AND is_string($filter)) {
            $where[] = $filter;
            $bindParams = array_merge($bindParams, $filterBindParams);
        }
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }

        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$radky) {
            return array();
        }
        foreach($radky as $data) {
            $vypis[] = new Projektor2_Model_Db_Read_ZajemceOsobniUdaje(
                    $data['id_zajemce'], $data['identifikator'], $data['znacka'], 
                    $data['titul'], $data['titul_za'], $data['jmeno'], $data['prijmeni'], $data['rodne_cislo'], $data['datum_narozeni'], $data['pohlavi']
                );
            }

        return $vypis;
    }
}