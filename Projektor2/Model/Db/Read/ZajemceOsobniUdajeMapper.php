<?php
class Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper {

    const SQL = "
SELECT zajemce.id_zajemce, identifikator, znacka,
		titul, titul_za, jmeno, prijmeni, datum_narozeni, rodne_cislo, pohlavi,
		mobilni_telefon, mail,
        faze,
        registrace_zajemce, registrace_uchazec, rekvalifikace_zajemce, rekvalifikace_uchazec,
        datum_ukonceni, duvod_ukonceni, dokonceno, datum_certif,
        zam_datum_vstupu, zam_forma, zam_nove_misto, zam_supm, zam_navazujici_datum_vstupu

FROM
zajemce
LEFT JOIN za_flat_table ON (zajemce.id_zajemce=za_flat_table.id_zajemce)
LEFT JOIN za_cizinec_flat_table ON (zajemce.id_zajemce=za_cizinec_flat_table.id_zajemce)
LEFT JOIN
(
SELECT
id_zajemce_FK,
sum(if(id_upload_type_FK='registrace zájemce', 1, 0)) AS registrace_zajemce,
sum(if(id_upload_type_FK='registrace uchazeč', 1, 0)) AS registrace_uchazec,
sum(if(id_upload_type_FK='rekvalifikace zájemce', 1, 0)) AS rekvalifikace_zajemce,
sum(if(id_upload_type_FK='rekvalifikace uchazeč', 1, 0)) AS rekvalifikace_uchazec
FROM
za_upload
GROUP BY id_zajemce_FK
) AS upload ON (zajemce.id_zajemce=upload.id_zajemce_FK)
LEFT JOIN za_ukonc_flat_table ON (zajemce.id_zajemce=za_ukonc_flat_table.id_zajemce)
LEFT JOIN za_zam_flat_table ON (zajemce.id_zajemce=za_zam_flat_table.id_zajemce)
";

    /**
     *
     * @param type $id
     * @param type $findInvalid
     * @param type $findOutOfContext
     * @return \Projektor2_Model_Db_Read_ZajemceOsobniUdaje
     */
    public static function findById($id) {
        $dbh = Config_AppContext::getDb();
        $query = self::SQL;
        $where[] = "zajemce.id_zajemce = :id_zajemce";
        $bindParams = array('id_zajemce'=>$id);
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(!$data) {
            return NULL;
        }
        return self::create($data);
    }

    /**
     *
     * @param type $filter
     * @param type $filterBindParams
     * @param type $order
     * @param type $findInvalid
     * @return \Projektor2_Model_Db_Read_ZajemceOsobniUdaje[]
     */
    public static function find($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE) {
        $dbh = Config_AppContext::getDb();
        $query = self::SQL;

        $where = array();
        $bindParams = array();
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }
        if ($filter AND is_string($filter)) {
            $where[] = $filter;
            $bindParams = array_merge($bindParams, $filterBindParams);
        }
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }

        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$radky) {
            return array();
        }
        foreach($radky as $data) {
            $vypis[] = self::create($data);
        }

        return $vypis;
    }

    /**
     *
     * @param type $filter
     * @param type $filterBindParams
     * @param type $order
     * @param type $findInvalid
     * @param type $findOutOfContext
     * @return \Projektor2_Model_Db_Read_ZajemceOsobniUdaje[]
     */
    public static function findInContext($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Config_AppContext::getDb();
        $appStatus = Projektor2_Model_Status::getSessionStatus();
        $query = self::SQL;

        $where = array();
        $bindParams = array();
        if (!$findOutOfContext) {
            if (isset($appStatus->getUserStatus()->getProjekt()->id)) {
                $where[] = "id_c_projekt_FK = :id_c_projekt_FK";
                $bindParams = array_merge($bindParams, array('id_c_projekt_FK'=>$appStatus->getUserStatus()->getProjekt()->id));
            }
            if (isset($appStatus->getUserStatus()->getKancelar()->id)) {
                $where[] = "id_c_kancelar_FK = :id_c_kancelar_FK";
                $bindParams = array_merge($bindParams, array('id_c_kancelar_FK'=>$appStatus->getUserStatus()->getKancelar()->id));
            }
            if (isset($appStatus->getUserStatus()->getBeh()->id)) {
                $where[] = "id_s_beh_projektu_FK = :id_s_beh_projektu_FK";
                $bindParams = array_merge($bindParams, array('id_s_beh_projektu_FK'=>$appStatus->getUserStatus()->getBeh()->id));
            }
        }
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }
        if ($filter AND is_string($filter)) {
            $where[] = $filter;
            $bindParams = array_merge($bindParams, $filterBindParams);
        }
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }

        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);
        if(!$radky) {
            return array();
        }
        foreach($radky as $data) {
            $vypis[] = self::create($data);
        }

        return $vypis ?? [];
    }

    private static function create($data) {
            return new Projektor2_Model_Db_Read_ZajemceOsobniUdaje(
                $data['id_zajemce'], $data['identifikator'], $data['znacka'],
                $data['titul'], $data['titul_za'], $data['jmeno'], $data['prijmeni'], $data['rodne_cislo'], $data['datum_narozeni'], $data['pohlavi'],
                $data['mobilni_telefon'], $data['mail'],
                $data['faze'],
                $data['registrace_zajemce'], $data['registrace_uchazec'], $data['rekvalifikace_zajemce'], $data['rekvalifikace_uchazec'],
                $data['datum_ukonceni'], $data['duvod_ukonceni'], $data['dokonceno'], $data['datum_certif'],
                $data['zam_datum_vstupu'], $data['zam_forma'], $data['zam_nove_misto'], $data['zam_supm'], $data['zam_navazujici_datum_vstupu']
                );
    }
}