<?php
class Projektor2_Model_Db_ZaUploadMapper {

    /**
     *
     * @param type $id
     * @return Projektor2_Model_Db_ZaUpload
     */
    public static function get($idZajemce, $typeUploadType) {
        $dbh = Config_AppContext::getDb();
        $query = "
SELECT `za_upload`.`id_zajemce_FK`,
    `za_upload`.`id_upload_type_FK`,
    `za_upload`.`filename`,
    `za_upload`.`creating_time`,
    `za_upload`.`creator`,
    `za_upload`.`service`,
    `za_upload`.`db_host`
FROM .`za_upload`
WHERE `id_zajemce_FK`=:id_zajemce_FK AND `id_upload_type_FK`=:id_upload_type_FK
                    ";
        $bindParams = ['id_zajemce_FK'=>$idZajemce, 'id_upload_type_FK'=>$typeUploadType];
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
     * @param Projektor2_Model_Db_ZaUploadType $uploadType
     * @return Projektor2_Model_Db_ZaUpload[]
     */
    public static function findByZajemce($idZajemce) {
        $dbh = Config_AppContext::getDb();
        $query = "
SELECT `za_upload`.`id_zajemce_FK`,
    `za_upload`.`id_upload_type_FK`,
    `za_upload`.`filename`,
    `za_upload`.`creating_time`,
    `za_upload`.`creator`,
    `za_upload`.`service`,
    `za_upload`.`db_host`
FROM .`za_upload`
WHERE `id_zajemce_FK`=:id_zajemce_FK
";
        $bindParams['id_zajemce_FK'] = $idZajemce;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return static::createCollection($data);
    }

    /**
     * Vytvoří nový záznam v databázi a vrací nový objekt Projektor2_Model_Db_ZaUpload.
     *
     * @param Projektor2_Model_Db_Zajemce $idZajemce
     * @param Projektor2_Model_Db_ZaUploadType $typeUploadType
     * @param type $filename
     * @param type $creator
     * @param type $service
     * @param type $dbHost
     * @return Projektor2_Model_Db_ZaUpload
     */
    public static function create($idZajemce, $typeUploadType, $filename, $creator, $service, $dbHost) {
        $dbh = Config_AppContext::getDb();

        $modelUpload = new Projektor2_Model_Db_ZaUpload($idZajemce, $typeUploadType, $filename, $creator, $service, $db_host);

        // !! creating_time je TIMESTAMP s DEFAULT CURRENT_TIMESTAMP
        foreach ($modelUpload as $key => $value) {
            if ($key!='creating_time') {  // vyloučen sloupec TIMESTAMP
                $columns[] = $key;
                $values[] = ':'.$key;
                $bindParams[$key] = $value;
            }
        }
        $query = "INSERT INTO `za_upload` (".implode(', ', $columns).")
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
            return new Projektor2_Model_Db_ZaUpload(
                $row['id_zajemce_FK'], $row['id_upload_type_FK'], $row['filename'], $row['creator'], $row['service'], $row['db_host'], $row['creating_time']);
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

    public static function update(Projektor2_Model_Db_ZaUpload $zaUpload) {
        $dbh = Config_AppContext::getDb();
        foreach ($zaUpload as $key => $value) {
            if ($key!='id_zajemce_FK' AND $key!='id_upload_type_FK' AND $key!='creating_time') {  // vyloučeny sloupce PRIMARY KEY a TIMESTAMP
                $set[] = $key.'=:'.$key;
                $bindParams[$key] = $value;
            }
        }
        $bindParams['id_zajemce_FK']=$zaUpload->id_zajemce_FK;
        $bindParams['id_upload_type_FK']=$zaUpload->id_upload_type_FK;


        $query = "UPDATE za_upload SET ".implode(', ', $set)." WHERE `id_zajemce_FK`=:id_zajemce_FK AND `id_upload_type_FK`=:id_upload_type_FK";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            return $zaUpload;
        } else {
            return NULL;
        }
    }

    public static function delete(Projektor2_Model_Db_ZaUpload $zaUpload) {
        $dbh = Config_AppContext::getDb();

        $query = "DELETE FROM za_upload WHERE `id_zajemce_FK`=:id_zajemce_FK AND `id_upload_type_FK`=:id_upload_type_FK";
        $bindParams = ['id_zajemce_FK'=>$zaUpload->id_zajemce_FK, 'id_upload_type_FK'=>$zaUpload->id_upload_type_FK];
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            unset( $zaUpload);
        }
    }
}
