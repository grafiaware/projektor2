<?php
class Projektor2_Model_Db_UploadTypeMapper {

    /**
     *
     * @param type $type
     * @return Projektor2_Model_Db_CertifikatKurz
     */
    public static function get($type) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
SELECT `upload_type`.`type`,
    `upload_type`.`popis`
FROM `upload_type`
WHERE `type`=:type
                    ";
        $bindParams = array('type'=>$type);
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
    public static function findAll() {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
SELECT `upload_type`.`type`,
    `upload_type`.`popis`
FROM `upload_type`
                    ";
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
    public static function create(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_UploadType $uploadType, $filename, $creator, $service, $dbHost) {
        $dbh = Projektor2_AppContext::getDb();

        $modelUpload = new Projektor2_Model_Db_Upload($zajemce->id, $uploadType->type, $filename, $creator, $service, $db_host);

        // !! creating_time je TIMESTAMP s DEFAULT CURRENT_TIMESTAMP
        foreach ($modelUpload as $key => $value) {
            if ($key!='id' AND $key!='creating_time') {  // vyloučen sloupec PRIMARY KEY a TIMESTAMP
                $columns[] = $key;
                $values[] = ':'.$key;
                $bindParams[$key] = $value;
            }
        }
        $query = "INSERT INTO `upload` (".implode(', ', $columns).")
                  VALUES (".  implode(', ', $values).")";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            $modelUpload->id_upload = $dbh->lastInsertId();
        } else {
            unset($modelUpload);
        }
        return $modelUpload;
    }

    private static function createItem($row) {
        if($row) {
            return new Projektor2_Model_Db_CertifikatKurz(
                $row['id_upload'], $row['id_zajemce_FK'], $row['id_upload_typ_FK'], $row['filename'], $row['creating_time'], $row['creator'], $row['service'], $row['db_host']);
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

    public static function update(Projektor2_Model_Db_Upload $upload) {
        $dbh = Projektor2_AppContext::getDb();
        foreach ($upload as $key => $value) {
            if ($key!='id_upload' AND $key!='creating_time') {  // vyloučen sloupec PRIMARY KEY a TIMESTAMP
                $set[] = $key.'=:'.$key;
                $bindParams[$key] = $value;
            }
        }
        $bindParams['id_upload'] = $upload->id_upload;

        $query = "UPDATE upload SET ".implode(', ', $set)." WHERE id_upload=:id_upload";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            return $upload;
        } else {
            return NULL;
        }
    }

    public static function delete(Projektor2_Model_Db_Upload $upload) {
        $dbh = Projektor2_AppContext::getDb();

        $query = "DELETE FROM upload WHERE id_upload=:id_upload";
        $bindParams = array('id_upload'=>$upload->id_upload);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            unset( $upload);
        }
    }
}
