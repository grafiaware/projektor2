<?php
class Projektor2_Model_Db_ZaUploadTypeMapper {

    /**
     *
     * @param type $type
     * @return \Projektor2_Model_Db_ZaUploadType
     */
    public static function get($type) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
SELECT `za_upload_type`.`type`,
    `za_upload_type`.`popis`
FROM `za_upload_type`
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
     * @return \Projektor2_Model_Db_ZaUploadType[]
     */
    public static function findAll() {
        $dbh = Projektor2_AppContext::getDb();
        $query = "
SELECT `za_upload_type`.`type`,
    `za_upload_type`.`popis`
FROM `za_upload_type`
                    ";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return static::createCollection($data);
    }

    /**
     *
     * @param type $uploadType
     * @param type $popis
     * @return \Projektor2_Model_Db_ZaUploadType|null
     */
    public static function create($uploadType, $popis) {
        $dbh = Projektor2_AppContext::getDb();

        $modelUpload = new Projektor2_Model_Db_ZaUploadType($uploadType, $popis);

        // !! creating_time je TIMESTAMP s DEFAULT CURRENT_TIMESTAMP
        foreach ($modelUpload as $key => $value) {
                $columns[] = $key;
                $values[] = ':'.$key;
                $bindParams[$key] = $value;
        }
        $query = "INSERT INTO `za_upload_type` (".implode(', ', $columns).")
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

    /**
     *
     * @param type $row
     * @return \Projektor2_Model_Db_ZaUploadType
     */
    private static function createItem($row) {
        if($row) {
            return new Projektor2_Model_Db_ZaUploadType($row['type'], $row['popis']);
        }
    }

    /**
     *
     * @param type $data
     * @return \Projektor2_Model_Db_ZaUploadType[]
     */
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

    public static function update(Projektor2_Model_Db_ZaUploadType $zaUploadType) {
        $dbh = Projektor2_AppContext::getDb();
        foreach ($zaUploadType as $key => $value) {
                $set[] = $key.'=:'.$key;
                $bindParams[$key] = $value;
        }
        $bindParams = ['type2'=>$zaUploadType->type];
        $query = "UPDATE za_upload_type SET ".implode(', ', $set)." WHERE type=:type2"; // dvakrát placeholder
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            return $zaUploadType;
        } else {
            return NULL;
        }
    }

    public static function delete(Projektor2_Model_Db_ZaUploadType $zaUploadType) {
        $dbh = Projektor2_AppContext::getDb();

        $query = "DELETE FROM za_upload_type WHERE type=:type";
        $bindParams = ['type'=>$zaUploadType->type];
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            unset( $zaUploadType);
        }
    }
}
