<?php
class Framework_Database_HandlerSqlMysql_Neon extends Framework_Database_HandlerSqlMysql {
    public function __construct($dbName='', $user='', $pass='', $dbHost='', $dbPort='', $charset='') {
        parent::__construct("projektor_2", "root", "spravce", "192.168.10.52");
//        parent::__construct("projektor_2", "root", "spravce", "neon");
    }
}

?>