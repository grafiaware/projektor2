<?php
class Projektor2_Model_Db_ZajemceMapper {

    public static function create() {
        $appStatus = Projektor2_Model_Status::getSessionStatus();
        if(!$appStatus->getUserStatus()->getProjekt() OR !$appStatus->getUserStatus()->getKancelar()) {
            throw new Exception ("Cannot create new zajemce - kancelar,projekt - one or more are not setted or setted improperly");
        }
        $dbh = Config_AppContext::getDb();
        // select a insert v transakci
        $dbh->beginTransaction();
        // select se zamknutím tabulky pro modifikaci
        $query = "SELECT Max(zajemce.cislo_zajemce) AS maxU  FROM zajemce
                  WHERE (id_c_projekt_FK = :id_c_projekt_FK AND id_c_kancelar_FK = :id_c_kancelar_FK )
                  LOCK IN SHARE MODE";  //vybírá i nevalidní
        $bindParams = array('id_c_projekt_FK'=>$appStatus->getUserStatus()->getProjekt()->id, 'id_c_kancelar_FK'=>$appStatus->getUserStatus()->getKancelar()->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        if ($data['maxU']) {
            $nove_cislo_ucastnika= $data['maxU'] + 1 ;
        } else {
            $nove_cislo_ucastnika = 1;
        }
        $identifikator = new Projektor2_ItemID($appStatus->getUserStatus()->getProjekt()->id, $appStatus->getUserStatus()->getKancelar()->id,1);
        $identifikator->u_cislo_polozky = $nove_cislo_ucastnika;
        $identifikator->c_cislo_behu = $appStatus->getUserStatus()->getBeh()->beh_cislo;
        $identifikator->c_oznaceni_turnusu = $appStatus->getUserStatus()->getBeh()->oznaceni_turnusu;

        $retezec = strval($nove_cislo_ucastnika);
        $retezec = str_pad($retezec, 3, "0", STR_PAD_LEFT); // doplní zleva nulami na 3 místa
        $znacka = $appStatus->getUserStatus()->getBeh()->oznaceni_turnusu.'-'.$appStatus->getUserStatus()->getKancelar()->kod.'-'.$retezec;

        $query = "INSERT INTO  zajemce (cislo_zajemce, identifikator, znacka, id_c_projekt_FK, id_c_kancelar_FK,id_s_beh_projektu_FK )
                  VALUES (:cislo_zajemce, :identifikator, :znacka, :id_c_projekt_FK, :id_c_kancelar_FK, :id_s_beh_projektu_FK)";
        $bindParams = array('cislo_zajemce'=>$nove_cislo_ucastnika, 'identifikator'=>$identifikator->generuj_cislo(),
                            'znacka'=>$znacka, 'id_c_projekt_FK'=>$appStatus->getUserStatus()->getProjekt()->id,
                            'id_c_kancelar_FK'=>$appStatus->getUserStatus()->getKancelar()->id, 'id_s_beh_projektu_FK'=>$appStatus->getUserStatus()->getBeh()->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $newId = $dbh->lastInsertId();
        $success = $dbh->commit();
        return $success ? Projektor2_Model_Db_ZajemceMapper::get($newId) : null;
    }

    public static function get($id, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT * FROM zajemce";
        $where[] = "id_zajemce = :id_zajemce";
        $bindParams = array('id_zajemce'=>$id);
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_Zajemce($data['cislo_zajemce'], $data['identifikator'], $data['znacka'], $data['id_c_projekt_FK'], $data['id_c_kancelar_FK'], $data['id_s_beh_projektu_FK'], $data['id_zajemce']);
    }

    public static function find($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Config_AppContext::getDb();
        $appStatus = Projektor2_Model_Status::getSessionStatus();
        $query = "SELECT * FROM zajemce";
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
            $bindParams = array_merge($filterBindParams);
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
        foreach($radky as $radek) {
            $vypis[] =  new Projektor2_Model_Db_Zajemce($radek['cislo_zajemce'], $radek['identifikator'], $radek['znacka'], $radek['id_c_projekt_FK'], $radek['id_c_kancelar_FK'], $radek['id_s_beh_projektu_FK'], $radek['id_zajemce']);
        }

        return $vypis;
    }

    public static function findAllForProject($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE) {
        $appStatus = Projektor2_Model_Status::getSessionStatus();
        if ($filter AND is_string($filter)) {
            $newFilter = $filter.' AND id_c_projekt_FK = :id_c_projekt_FK';
            $newFilterBindParams = array_merge($filterBindParams, array('id_c_projekt_FK'=>$appStatus->getUserStatus()->getProjekt()->id));
        } else {
            $newFilter = ' id_c_projekt_FK = :id_c_projekt_FK';
            $newFilterBindParams = array('id_c_projekt_FK'=>$appStatus->getUserStatus()->getProjekt()->id);
        }
        return self::find($newFilter, $newFilterBindParams, $order, $findInvalid, TRUE);
    }
}
