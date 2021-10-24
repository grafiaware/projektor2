<?php
/**
 * Description of Cache
 *
 * @author pes2704
 */
class Framework_Database_Cache {

    static $attributes = array();
    static $primaryKeys = array();

    public static function getAttributes(Framework_Database_HandlerInterface $dbh, $tableName) {
        $dbName = $dbh->getDbName();
        if (!isset(self::$attributes[$dbName][$tableName])) {
            self::readColumns($dbh, $tableName);
        }
        return self::$attributes[$dbName][$tableName];
    }

    /**
     * Vrací název primárního klíče tabulky
     * @param Framework_Database_HandlerInterface $dbh
     * @param type $tableName
     * @return string
     */
    public static function getPrimaryKeyName(Framework_Database_HandlerInterface $dbh, $tableName) {
        $dbName = $dbh->getDbName();
        if (!isset(self::$attributes[$dbName][$tableName])) {  //tabulka nemusí mít primární klíč, ale vždy má sloupce
            self::readColumns($dbh, $tableName);
        }
        return self::$primaryKeys[$dbName][$tableName];
    }

    /**
     * Nastaví pole attributes - vytvoří asociativní pole ve struktuře $attributes[dbName][tableName][columnName] a naplní ho default hodnotami sloupců.
     * Současně také nastaví 
     *
     * @param Framework_Database_HandlerInterface $dbh
     * @param type $tableName
     */
    private static  function readColumns(Framework_Database_HandlerInterface $dbh, $tableName) {
        $dbName = $dbh->getDbName();
        //Nacteni struktury tabulky, datovych typu a ost parametru tabulky
        $query = "SHOW COLUMNS FROM ".$tableName;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $columnsInfo = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach($columnsInfo as $columnInfo) {
            self::$attributes[$dbName][$tableName][$columnInfo['Field']] = $columnInfo['Default'];
            if ($columnInfo['Key']=="PRI") self::$primaryKeys[$dbName][$tableName] = $columnInfo['Field'];
        }
    }
}
