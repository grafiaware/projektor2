<?php
class Projektor2_DB_Mysql_NeonProjektor2col extends Framework_Database_HandlerSqlMysql {

    public function __construct($dbName='', $user='', $pass='', $dbHost='', $dbPort='', $charset='') {

        parent::__construct("projektor2col", "root", "spravce", "neon");
    }
}