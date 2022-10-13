<?php
class Projektor2_Model_Db_CertifikatKurzMapper {

    /**
     *
     * @param type $id
     * @return Projektor2_Model_Db_CertifikatKurz
     */
    public static function get($id) {
        $dbh = Projektor2_AppContext::getDb();
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
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param int $certificateType
     * @return type
     */
    public static function find(Projektor2_Model_Db_Zajemce $zajemce=NULL, Projektor2_Model_Db_SKurz $sKurz=NULL, $certificateType=FALSE) {
        $dbh = Projektor2_AppContext::getDb();
        if ($zajemce) {
            $conditionTokens[] = 'id_zajemce_FK = :id_zajemce_FK';
            $bindParams['id_zajemce_FK'] = $zajemce->id;
        }
        if ($sKurz) {
            $conditionTokens[] = 'id_s_kurz_FK = :id_s_kurz_FK';
            $bindParams['id_s_kurz_FK'] = $sKurz->id_s_kurz;
        }
        if($certificateType) {
            $conditionTokens[] = 'typ = :typ';
            $bindParams['typ'] = $certificateType;
        }
        $query = "SELECT * FROM certifikat_kurz join certifikat_kurz_typ on certifikat_kurz.id_certifikat_kurz_typ_FK=certifikat_kurz_typ.id_certifikat_kurz_typ";
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
     * @param int $certificateType Typ certifikátu musí být hodnota existující v tabulce certifikat_kurz_typ
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param Projektor2_Date $date
     * @param string $fileName
     * @return Projektor2_Model_Db_CertifikatKurz
     */
    public static function create($certificateType, Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz,
                                    Projektor2_Date $date, $creator, $service, $fileName=NULL) {
        $rok = $date->getCzechStringYear();

        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM certifikat_kurz_typ WHERE typ=:typ";  //vybírá i nevalidní
        $bindParams = array('typ'=>$certificateType);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $typRow = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$typRow) {
            throw new LogicException('Selhalo nalezení zadaného typu cetifikátu, typ certifikátu: '.$certificateType);
        }

        $query = "SELECT Max(cislo) AS maxCislo  FROM certifikat_kurz WHERE rok=:rok AND id_certifikat_kurz_typ_FK=:id_certifikat_kurz_typ_FK";  //vybírá i nevalidní
        $bindParams = array('rok'=>$rok, 'id_certifikat_kurz_typ_FK'=>$typRow['id_certifikat_kurz_typ']);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            throw new LogicException('Selhalo nalezení posledního použitého čísla certifikátu. Rok:'.$rok.', typ certifikátu: '.$certificateType);
        }
        if ($data['maxCislo']) {
            $cisloCertifikatu= $data['maxCislo'] + 1 ;
        } else {
            $cisloCertifikatu = 1;
        }
        $now = new DateTime("now");
        $modelCertifikatKurz = new Projektor2_Model_Db_CertifikatKurz($zajemce->id, $typRow['id_certifikat_kurz_typ'], $sKurz->id_s_kurz,
            $cisloCertifikatu, $rok, Projektor2_AppContext::getCertificateKurzIdentificator($certificateType, $rok, $cisloCertifikatu),
            $fileName, $date->getSqlDate(),
            $now->format("Y-m-d H:i:s"),
            $creator, $service, $dbh->getDbHost());

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
        $succ = $sth->execute($bindParams);
        if ($succ) {
            $modelCertifikatKurz->id = $dbh->lastInsertId();
        } else {
            unset($modelCertifikatKurz);
        }
        return $modelCertifikatKurz;
//        $data = $sth->fetch(PDO::FETCH_ASSOC);
//        // model vytvořen načtením z databáze na základě last insert id
//        return self::findById($dbh->lastInsertId());
    }

    private static function createItem($row) {
        if($row) {
            return new Projektor2_Model_Db_CertifikatKurz($row['id_zajemce_FK'], $row['id_certifikat_kurz_typ_FK'], $row['id_s_kurz_FK'],
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
        $dbh = Projektor2_AppContext::getDb();
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
        $dbh = Projektor2_AppContext::getDb();

        $query = "DELETE FROM certifikat_kurz WHERE id_certifikat_kurz=:id_certifikat_kurz";
        $bindParams = array('id_certifikat_kurz'=>$kurzCertifikat->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            unset( $kurzCertifikat);
        }
    }
}
