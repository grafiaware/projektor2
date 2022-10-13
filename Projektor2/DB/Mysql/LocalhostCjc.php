<?php
class Projektor2_DB_Mysql_LocalhostCjc extends Framework_Database_HandlerSqlMysql {

    public function __construct($dbName='', $user='', $pass='', $dbHost='', $dbPort='', $charset='') {

        parent::__construct("projektor_2_cjc", "root", "spravce", "localhost");
    }
}
