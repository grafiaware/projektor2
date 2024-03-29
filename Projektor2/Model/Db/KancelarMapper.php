<?php
class Projektor2_Model_Db_KancelarMapper {
    public static function getValid($id) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT * FROM c_kancelar WHERE id_c_kancelar = :id_c_kancelar AND valid = 1";
        $bindParams = array('id_c_kancelar'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_Kancelar($data['id_c_kancelar'], $data['id_c_projekt_FK'], $data['razeni'], $data['kod'], $data['text'], $data['plny_text'], $data['valid']);
    }

    public static function findValid($filter = NULL, $order = NULL) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT * FROM c_kancelar WHERE valid = 1";
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }

        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows) {
            return array();
        }
        foreach($rows as $data) {
            $vypis[] = new Projektor2_Model_Db_Kancelar($data['id_c_kancelar'], $data['id_c_projekt_FK'], $data['razeni'], $data['kod'], $data['text'], $data['plny_text'], $data['valid']);
        }
        return $vypis;
    }
}

?>