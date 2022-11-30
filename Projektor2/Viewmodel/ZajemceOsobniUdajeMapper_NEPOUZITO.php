<?php
class Projektor2_Viewmodel_ZajemceOsobniUdajeMapper {
    public static function findById($id, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $zajemceDbReadOsobniUdaje = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findById($id, $findInvalid, $findOutOfContext);
        if (isset($zajemceDbReadOsobniUdaje)) {
            return new Projektor2_Viewmodel_ZajemceOsobniUdaje($zajemceDbReadOsobniUdaje->id, $zajemceDbReadOsobniUdaje->zajemce,
                            $zajemceDbReadOsobniUdaje->jmeno, $zajemceDbReadOsobniUdaje->prijmeni, $zajemceDbReadOsobniUdaje->datum_narozeni, $zajemceDbReadOsobniUdaje->rodne_cislo,
                            $zajemceDbReadOsobniUdaje->pohlavi, $zajemceDbReadOsobniUdaje->titul, $zajemceDbReadOsobniUdaje->titul_za    );
        }
//        return new Projektor2_Model_ZajemceOsobniUdaje($data['id_zajemce'], $zajemce,
//                            $data['jmeno'], $data['prijmeni'], $data['datum_narozeni'], $data['rodne_cislo'],
//                            $data['pohlavi'], $data['titul'], $data['titul_za']    );
    }

    public static function find($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE) {
        $zajemciDbReadOsobniUdaje = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::find($filter, $filterBindParams, $order, $findInvalid);
        return new Projektor2_Viewmodel_ZajemceOsobniUdaje($zajemceDbReadOsobniUdaje->id, $zajemceDbReadOsobniUdaje->zajemce,
                            $zajemceDbReadOsobniUdaje->jmeno, $zajemceDbReadOsobniUdaje->prijmeni, $zajemceDbReadOsobniUdaje->datum_narozeni, $zajemceDbReadOsobniUdaje->rodne_cislo,
                            $zajemceDbReadOsobniUdaje->pohlavi, $zajemceDbReadOsobniUdaje->titul, $zajemceDbReadOsobniUdaje->titul_za    );
        foreach($zajemciDbReadOsobniUdaje as $zajemceDbReadOsobniUdaje) {
            $zajemce = new Projektor2_Model_Db_Zajemce($data['cislo_zajemce'], $data['identifikator'], $data['znacka'], $data['id_c_projekt_FK'], $data['id_c_kancelar_FK'], $data['id_s_beh_projektu_FK'], $data['id_zajemce']);
            $vypis[] = new Projektor2_Viewmodel_ZajemceOsobniUdaje($zajemceDbReadOsobniUdaje->id, $zajemceDbReadOsobniUdaje->zajemce,
                            $zajemceDbReadOsobniUdaje->jmeno, $zajemceDbReadOsobniUdaje->prijmeni, $zajemceDbReadOsobniUdaje->datum_narozeni, $zajemceDbReadOsobniUdaje->rodne_cislo,
                            $zajemceDbReadOsobniUdaje->pohlavi, $zajemceDbReadOsobniUdaje->titul, $zajemceDbReadOsobniUdaje->titul_za    );
        }

        return $vypis ?? [];
    }

    public static function findInContext($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $zajemciDbReadOsobniUdaje = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findInContext($filter, $filterBindParams, $order, $findInvalid, $findOutOfContext);
        return new Projektor2_Viewmodel_ZajemceOsobniUdaje($zajemceDbReadOsobniUdaje->id, $zajemceDbReadOsobniUdaje->zajemce,
                            $zajemceDbReadOsobniUdaje->jmeno, $zajemceDbReadOsobniUdaje->prijmeni, $zajemceDbReadOsobniUdaje->datum_narozeni, $zajemceDbReadOsobniUdaje->rodne_cislo,
                            $zajemceDbReadOsobniUdaje->pohlavi, $zajemceDbReadOsobniUdaje->titul, $zajemceDbReadOsobniUdaje->titul_za    );
        foreach($zajemciDbReadOsobniUdaje as $zajemceDbReadOsobniUdaje) {
            $zajemce = new Projektor2_Model_Db_Zajemce($data['cislo_zajemce'], $data['identifikator'], $data['znacka'], $data['id_c_projekt_FK'], $data['id_c_kancelar_FK'], $data['id_s_beh_projektu_FK'], $data['id_zajemce']);
            $vypis[] = new Projektor2_Viewmodel_ZajemceOsobniUdaje($zajemceDbReadOsobniUdaje->id, $zajemceDbReadOsobniUdaje->zajemce,
                            $zajemceDbReadOsobniUdaje->jmeno, $zajemceDbReadOsobniUdaje->prijmeni, $zajemceDbReadOsobniUdaje->datum_narozeni, $zajemceDbReadOsobniUdaje->rodne_cislo,
                            $zajemceDbReadOsobniUdaje->pohlavi, $zajemceDbReadOsobniUdaje->titul, $zajemceDbReadOsobniUdaje->titul_za    );
        }

        return $vypis ?? [];
    }
}