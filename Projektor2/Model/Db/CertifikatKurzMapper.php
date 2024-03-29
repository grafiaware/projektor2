<?php
class Projektor2_Model_Db_CertifikatKurzMapper {

    /**
     *
     * @param type $id
     * @return Projektor2_Model_Db_CertifikatKurz
     */
    public static function get($id) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT * FROM certifikat_kurz join certifikat_kurz_typ on certifikat_kurz.id_certifikat_kurz_typ_FK=certifikat_kurz_typ.id_certifikat_kurz "
                . " WHERE id_certifikat_kurz = :id_certifikat_kurz";
        $bindParams = array('id_certifikat_kurz'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return static::createItem($row);
    }

    /**
     *
     * @param int $zajemce
     * @param int $idSKurz
     * @param string $certifikatKurzRada
     * @param string $certifikatKurzVerze
     * @return array
     */
    public static function find($idZajemce=null, $idSKurz=null, $certifikatKurzRada=null, $certifikatKurzVerze=null) {
        $dbh = Config_AppContext::getDb();
        if ($idZajemce) {
            $conditionTokens[] = 'id_zajemce_FK = :id_zajemce_FK';
            $bindParams['id_zajemce_FK'] = $idZajemce;
        }
        if ($idSKurz) {
            $conditionTokens[] = 'id_s_kurz_FK = :id_s_kurz_FK';
            $bindParams['id_s_kurz_FK'] = $idSKurz;
        }
        if($certifikatKurzRada) {
            $conditionTokens[] = 'certifikat_kurz_rada_FK = :certifikat_kurz_rada_FK';
            $bindParams['certifikat_kurz_rada_FK'] = $certifikatKurzRada;
        }
        if($certifikatKurzVerze) {
            $conditionTokens[] = 'certifikat_kurz_verze_FK = :certifikat_kurz_verze_FK';
            $bindParams['certifikat_kurz_verze_FK'] = $certifikatKurzVerze;
        }
        $query = "SELECT * FROM certifikat_kurz join certifikat_kurz_rada on certifikat_kurz.certifikat_kurz_rada_FK=certifikat_kurz_rada.rada";
        if ($conditionTokens) {
            $query .= ' WHERE '.implode(' AND ', $conditionTokens);
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return static::createCollection($data);
    }

    /**
     * Vytvoří nový záznam v databázi a vrací nový objekt Projektor2_Model_Certifikat.
     *
     * Číslo cerifikátu určí jako o jednotku vyšší než nejvyšší číslo již použité pro certifikátu zadaného typu v daném roce.
     * Rok určí automaticky z datutmu zadaného parametrem $createDate.
     * Každému záznamu v databázi metoda sama přidá položku db_host, která obsahuje název hostitele databáze, se kterou aplikace právě pracuje.
     * Tato položka může sloužit k rozpoznání a odstranění záznamů vzniklých při testování, kdy obvykle db_host=localhost.
     *
     * @param string $certifikatVerze Typ certifikátu musí být hodnota existující v tabulce certifikat_kurz_rada
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param Projektor2_Date $date
     * @param string $fileName
     * @return Projektor2_Model_Db_CertifikatKurz
     * @throws \Exception
     */
    public static function create(
            Projektor2_Model_Db_Zajemce $zajemce, 
            Projektor2_Model_Db_SKurz $sKurz, 
            $certifikatRada, 
            $certifikatVerze,
            Projektor2_Date $date, 
            $creator, $service, $fileName) {
        $dbh = Config_AppContext::getDb();

        $rok = $date->getCzechStringYear();
        try {
            // select a insert v transakci
            $dbh->beginTransaction();
            $cisloCertifikatu = self::readMaxCisloCertifikatu($dbh, $rok, $certifikatRada)+1;
            $now = new DateTime("now");

            $modelCertifikatKurz = new Projektor2_Model_Db_CertifikatKurz(
                    $zajemce->id, $sKurz->id_s_kurz, $certifikatRada, $certifikatVerze,
                    $cisloCertifikatu, $rok, Config_Certificates::getCertificateKurzIdentificator($sKurz->certifikat_kurz_rada_FK, $rok, $cisloCertifikatu),
                    $fileName, $date->getSqlDate(),
                    $now->format("Y-m-d H:i:s"),
                    $creator, $service, $dbh->getDbHost()
                );

            // !! creating_time je TIMESTAMP s DEFAULT CURRENT_TIMESTAMP
            foreach ($modelCertifikatKurz as $key => $value) {
                if ($key!='id' AND $key!='creating_time') {  // vyloučen sloupec PRIMARY KEY a TIMESTAMP
                    $columns[] = $key;
                    $values[] = ':'.$key;
                    $bindParams[$key] = $value;
                }
            }
            $query = "INSERT INTO certifikat_kurz (".implode(', ', $columns).")
                      VALUES (".  implode(', ', $values).")";

            $sth = $dbh->prepare($query);
            $sth->execute($bindParams);
            $newId = $dbh->lastInsertId();
            $success = $dbh->commit();
        } catch(\Exception $e) {
            $this->dbHandler->rollBack();
            throw $e;
        }
        $modelCertifikatKurz->id = $newId;
        return $modelCertifikatKurz;
    }

    private static function readMaxCisloCertifikatu($dbh, $rok, $certifikatRada) {

        if (!$dbh->inTransaction()) {
            throw new LogicException('Nové číslo certáifikátu lze hledat a generovat pouze ve spuštěné transakci.');
        }
        $query =
        "SELECT `certifikat_kurz_rada`.`rada`
        FROM `certifikat_kurz_rada`
        WHERE rada=:rada
        ";  //vybírá i nevalidní
        $bindParams = array('rada'=>$certifikatRada);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radaRow = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$radaRow) {
            throw new LogicException('Selhalo nalezení zadaného typu cetifikátu, typ certifikátu: '.$certifikatRada);
        }
        $rada = $radaRow['rada'];

        $query = "SELECT Max(cislo) AS maxCislo  FROM certifikat_kurz WHERE rok=:rok AND certifikat_kurz_rada_FK=:certifikat_kurz_rada_FK";  //vybírá i nevalidní
        $bindParams = array('rok'=>$rok, 'certifikat_kurz_rada_FK'=>$rada);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            throw new LogicException('Selhalo nalezení posledního použitého čísla certifikátu. Rok:'.$rok.', typ certifikátu: '.$certifikatRada);
        }
        return $data['maxCislo'] ? $data['maxCislo'] : 0;
    }

    private static function createItem($row) {
        if($row) {
            return new Projektor2_Model_Db_CertifikatKurz($row['id_zajemce_FK'], $row['id_s_kurz_FK'], $row['certifikat_kurz_rada_FK'], $row['certifikat_kurz_verze_FK'],
                    $row['cislo'], $row['rok'], $row['identifikator'], $row['filename'], $row['date'],
                    $row['creating_time'], $row['creator'], $row['service'], $row['db_host'], $row['id_certifikat_kurz']);
        }
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

    public static function update(Projektor2_Model_Db_CertifikatKurz $kurzCertifikat) {
        $dbh = Config_AppContext::getDb();
        foreach ($kurzCertifikat as $key => $value) {
            if ($key!='id' AND $key!='creating_time') {  // vyloučen sloupec PRIMARY KEY a TIMESTAMP
                $set[] = $key.'=:'.$key;
                $bindParams[$key] = $value;
            }
        }
        $bindParams['id_certifikat_kurz'] = $kurzCertifikat->id;

        $query = "UPDATE certifikat_kurz SET ".implode(', ', $set)." WHERE id_certifikat_kurz=:id_certifikat_kurz";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            return $kurzCertifikat;
        } else {
            return NULL;
        }
    }

    public static function delete(Projektor2_Model_Db_CertifikatKurz $kurzCertifikat) {
        $dbh = Config_AppContext::getDb();

        $query = "DELETE FROM certifikat_kurz WHERE id_certifikat_kurz=:id_certifikat_kurz";
        $bindParams = array('id_certifikat_kurz'=>$kurzCertifikat->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            unset( $kurzCertifikat);
        }
    }
}
