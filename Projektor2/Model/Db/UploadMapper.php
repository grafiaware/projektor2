<?php
class Projektor2_Model_Db_UploadMapper {

    /**
     *
     * @param type $id
     * @return Projektor2_Model_Db_Upload
     */
    public static function get($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
SELECT `upload`.`id_upload`,
    `upload`.`id_zajemce_FK`,
    `upload`.`id_upload_typ_FK`,
    `upload`.`filename`,
    `upload`.`creating_time`,
    `upload`.`creator`,
    `upload`.`service`,
    `upload`.`db_host`
FROM `upload`
WHERE `id_upload`=:id_upload
                    ";
        $bindParams = array('id_upload'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return static::createItem($row);
    }

    /**
     *Přijímá parametry modely zajemce a uploadType
     * - pokud nejsou zadány, najde vše
     * - pokud je zadán jen zájemce - hledá vše pro zájemce
     * - pokud je zadán jen uploadType, hledá vše pro upload type
     *
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_UploadType $uploadType
     * @return Projektor2_Model_Db_Upload[]
     */
    public static function findByZajemceAndUploadType(Projektor2_Model_Db_Zajemce $zajemce=NULL, Projektor2_Model_Db_UploadType $uploadType=NULL) {
        $dbh = Projektor2_AppContext::getDb();
        if (isset($zajemce)) {
            $conditionTokens[] = 'id_zajemce_FK = :id_zajemce_FK';
            $bindParams['id_zajemce_FK'] = $zajemce->id;
        }
        if (isset($uploadType)) {
            $conditionTokens[] = 'id_upload_type_FK = :id_upload_type_FK';
            $bindParams['id_upload_type_FK'] = $uploadType->type;
        }
        $query = "
SELECT `upload`.`id_upload`,
    `upload`.`id_zajemce_FK`,
    `upload`.`id_upload_typ_FK`,
    `upload`.`filename`,
    `upload`.`creating_time`,
    `upload`.`creator`,
    `upload`.`service`,
    `upload`.`db_host`
FROM `upload`
WHERE `id_upload`=:id_upload
                    ";
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
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_UploadType $uploadType
     * @param type $filename
     * @param type $creator
     * @param type $service
     * @param type $dbHost
     * @return Projektor2_Model_Db_Upload
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
