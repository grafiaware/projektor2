<?php
class Projektor2_Model_Db_SKurzMapper {
    /**
     *
     * @param integer $id
     * @return \Projektor2_Model_Db_SKurz
     */
    public static function get($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
    SELECT
        `s_kurz`.`id_s_kurz`,
        `s_kurz`.`razeni`,
        `s_kurz`.`projekt_kod`,
        `s_kurz`.`kancelar_kod`,
        `s_kurz`.`kurz_druh`,
        `s_kurz`.`kurz_cislo`,
        `s_kurz`.`beh_cislo`,
        `s_kurz`.`kurz_lokace`,
        `s_kurz`.`kurz_zkratka`,
        `s_kurz`.`kurz_nazev`,
        `s_kurz`.`kurz_pracovni_cinnost`,
        `s_kurz`.`kurz_akreditace`,
        `s_kurz`.`kurz_obsah`,
        `s_kurz`.`pocet_hodin`,
        `s_kurz`.`pocet_hodin_distancne`,
        `s_kurz`.`certifikat_kurz_rada_FK`,
        `s_kurz`.`pocet_hodin_praxe`,
        `s_kurz`.`date_zacatek`,
        `s_kurz`.`date_konec`,
        `s_kurz`.`dodavatel`,
        `s_kurz`.`info_cas_konani`,
        `s_kurz`.`info_misto_konani`,
        `s_kurz`.`info_lektor`,
        `s_kurz`.`harmonogram_filename`,
        `s_kurz`.`valid`
    FROM `s_kurz`
            WHERE id_s_kurz = :id_s_kurz AND valid = 1
            ";
        $bindParams = array('id_s_kurz'=>$id);

        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return static::createItem($row);
    }

    /**
     *
     * @param type $filter
     * @param type $order
     * @return \Projektor2_Model_Db_SKurz[] array of \Projektor2_Model_Db_SKurz
     */
    public static function find($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
    SELECT
        `s_kurz`.`id_s_kurz`,
        `s_kurz`.`razeni`,
        `s_kurz`.`projekt_kod`,
        `s_kurz`.`kancelar_kod`,
        `s_kurz`.`kurz_druh`,
        `s_kurz`.`kurz_cislo`,
        `s_kurz`.`beh_cislo`,
        `s_kurz`.`kurz_lokace`,
        `s_kurz`.`kurz_zkratka`,
        `s_kurz`.`kurz_nazev`,
        `s_kurz`.`kurz_pracovni_cinnost`,
        `s_kurz`.`kurz_akreditace`,
        `s_kurz`.`kurz_obsah`,
        `s_kurz`.`pocet_hodin`,
        `s_kurz`.`pocet_hodin_distancne`,
        `s_kurz`.`certifikat_kurz_rada_FK`,
        `s_kurz`.`pocet_hodin_praxe`,
        `s_kurz`.`date_zacatek`,
        `s_kurz`.`date_konec`,
        `s_kurz`.`dodavatel`,
        `s_kurz`.`info_cas_konani`,
        `s_kurz`.`info_misto_konani`,
        `s_kurz`.`info_lektor`,
        `s_kurz`.`harmonogram_filename`,
        `s_kurz`.`valid`
    FROM `s_kurz`
            WHERE valid = 1
            ";
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return self::createCollection($data);
    }

    private static function createItem($row) {
        if($row) {
            $model = new Projektor2_Model_Db_SKurz($row['id_s_kurz'],$row['razeni'],$row['projekt_kod'],$row['kancelar_kod'],
                $row['kurz_druh'],$row['kurz_cislo'],$row['beh_cislo'],$row['kurz_lokace'],$row['kurz_zkratka'],
                $row['kurz_nazev'], $row['kurz_pracovni_cinnost'], $row['kurz_akreditace'], $row['kurz_obsah'],
                $row['pocet_hodin'], $row['pocet_hodin_distancne'], $row['pocet_hodin_praxe'], $row['certifikat_kurz_rada_FK'],
                $row['date_zacatek'], $row['date_konec'], $row['dodavatel'],
                    $row['info_cas_konani'], $row['info_misto_konani'], $row['info_lektor'], $row['harmonogram_filename'],
                    $row['valid']);
            }
            return $model ?? null;
    }

    private static function createCollection($data) {
        if(!$data) {
            $collection = [];
        } else {
            foreach ($data as $row) {
                $collection[] = static::createItem($row);
            }
        }
        return $collection;
    }

    /**
     * Vytvoří nový záznam v databázi a vrací nový objekt Projektor2_Model_Certifikat.
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_ZaUploadType $uploadType
     * @param type $filename
     * @param type $creator
     * @param type $service
     * @param type $dbHost
     * @return Projektor2_Model_Db_SKurz
     */
    public static function create(
        Projektor2_Model_Db_Projekt $projekt,
        Projektor2_Model_Db_Kancelar $kancelar,
        $razeni=null,
        $kurz_druh=null, $kurz_cislo=null, $beh_cislo=null, $kurz_lokace=null, $kurz_zkratka=null,
        $kurz_nazev=null, $kurz_pracovni_cinnost=null, $kurz_akreditace=null, $kurz_obsah=null,
        $pocet_hodin=null, $pocet_hodin_distancne=null, $pocet_hodin_praxe=null, $id_certifikat_kurz_typ_FK=null,
        $date_zacatek=null, $date_konec=null, $dodavatel=null,
        $info_cas_konani=null, $info_misto_konani=null, $info_lektor=null, $harmonogram_filename=null,
        $valid=null
            ) {
        $dbh = Projektor2_AppContext::getDb();

        $sKurz = new Projektor2_Model_Db_SKurz(
                $razeni, $projekt->kod, $kancelar->kod,
                $kurz_druh, $kurz_cislo, $beh_cislo, $kurz_lokace, $kurz_zkratka,
                $kurz_nazev, $kurz_pracovni_cinnost, $kurz_akreditace, $kurz_obsah,
                $pocet_hodin, $pocet_hodin_distancne, $pocet_hodin_praxe, $certifikat_kurz_rada_FK,
                $date_zacatek, $date_konec, $dodavatel,
                $info_cas_konani, $info_misto_konani, $info_lektor, $harmonogram_filename,
                $valid);

        foreach ($sKurz as $key => $value) {
            if (isset($value)) {
                if ($key!='id') {  // vyloučen sloupec PRIMARY KEY a TIMESTAMP
                    $columns[] = $key;
                    $values[] = ':'.$key;
                    $bindParams[$key] = $value;
                }
            }
        }
        $query = "INSERT INTO `s_kurz` (".implode(', ', $columns).")
                  VALUES (".  implode(', ', $values).")";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            $sKurz->id_s_kurz = $dbh->lastInsertId();
        } else {
            unset($sKurz);
        }
        return $sKurz;
    }

    public static function update(Projektor2_Model_Db_SKurz $sKurz) {
        $dbh = Projektor2_AppContext::getDb();
        foreach ($sKurz as $key => $value) {
            if (isset($value)) {
                if ($key!='id_s_kurz') {  //se seznamu sloupců vyloučen sloupec PRIMARY KEY
                    $set[] = $key.'=:'.$key;
                }
                $bindParams[$key] = $value;  // bind osahuje i PK - pro where
            }
        }

        $query = "UPDATE `s_kurz` SET ".implode(', ', $set)." WHERE `id_s_kurz`=:id_s_kurz";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            return $sKurz;
        } else {
            return NULL;
        }
    }

    public static function delete(Projektor2_Model_Db_SKurz $sKurz) {
        $dbh = Projektor2_AppContext::getDb();

        $query = "DELETE FROM `s_kurz` WHERE `id_s_kurz`=:id_s_kurz";
        $bindParams = ['id_s_kurz'=>$sKurz->id_s_kurz];
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            unset( $sKurz);
        }
    }

}
