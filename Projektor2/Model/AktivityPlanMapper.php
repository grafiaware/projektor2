<?php
/**
 * Description of Projektor2_Model_KurzPlanMapper
 *
 * @author pes2704
 */
class Projektor2_Model_AktivityPlanMapper {

    public static function findByIndexAktivity(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $indexAktivity) {
        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);
        $kurzPlan = NULL;
        if ($plan AND $aktivity) {
            $id = 0;
            $aktivita = $aktivity[$indexAktivity];
            $id++;
            $kurzPlan = self::creaAktivitaPlan($plan, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
        }
        return $kurzPlan;
    }

    /**
     * Vrací pole modelů Projektor2_Model_AktivitaPlan
     *
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param type $typAktivity
     * @return \Projektor2_Model_AktivitaPlan array

     */
//    public static function findAll(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $typAktivity=NULL) {
//        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
//        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
//        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);
//        $kolekce = array();
//        if ($plan AND $aktivity) {
//            $id = 0;
//            foreach ($aktivity as $indexAktivity=>$aktivita) {
//                $aktivitaPlan = self::creaAktivitaPlan($plan, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
//                if ($aktivitaPlan) {
//                    $id++;
//                    $kolekce[] = $aktivitaPlan;
//                }
//            }
//        } else {
//            $kolekce = array();
//        }
//        return $kolekce;
//    }

    /**
     * Vrací pole modelů Projektor2_Model_AktivitaPlan pro všechny aktivity projektu i nenaplánované
     *
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param type $typAktivity
     * @return \Projektor2_Model_AktivitaPlan array
     */
    public static function findAll(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $typAktivity=NULL) {
        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $planovaneKurzy = Projektor2_Model_Db_ZaPlanKurzMapper::findAllForZajemce($zajemce->id);

        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);
        $kolekce = array();
        if ($plan AND $aktivity) {
            $id = 0;
            $planSortedAssoc = self::getPlanSortedAssoc($planovaneKurzy);
            foreach ($aktivity as $indexAktivity=>$aktivita) {
                $planKurz = $planSortedAssoc[$indexAktivity] ?? null;
                $aktivitaPlan = self::createAktivitaPlan($planKurz, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
                if ($aktivitaPlan) {
                    $id++;
                    $kolekce[] = $aktivitaPlan;
                }
            }
        } else {
            $kolekce = array();
        }
        return $kolekce;
    }

    /**
     * Vrací asocitivní pole modelů Projektor2_Model_AktivitaPlan indexované indexem aktivity
     *
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param type $typAktivity
     * @return array
     */
//    public static function findAllAssoc(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $typAktivity=NULL) {
//        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
//        Projektor2_Model_Db_ZajemceMapper::
//        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
//        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);
//        if ($plan AND $aktivity) {
//            $id = 0;
//            foreach ($aktivity as $indexAktivity=>$aktivita) {
//                $aktivitaPlan = self::creaAktivitaPlan($plan, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
//                if ($aktivitaPlan) {
//                    $id++;
//                    $kolekce[$indexAktivity] = $aktivitaPlan;
//                }
//            }
//        } else {
//            $kolekce = array();
//        }
//        return $kolekce;
//    }

    /**
     * Vrací asocitivní pole modelů Projektor2_Model_AktivitaPlan indexované indexem aktivity
     *
     * @param Projektor2_Model_SessionStatus $sessionStatus
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param type $typAktivity
     * @return \Projektor2_Model_AktivitaPlan array

     */
    public static function findAllAssoc(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $typAktivity=NULL) {
        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $planovaneKurzy = Projektor2_Model_Db_ZaPlanKurzMapper::findAllForZajemce($zajemce->id);

        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);
        $kolekce = array();
        if ($plan AND $aktivity) {
            $id = 0;
            $planSortedAssoc = self::getPlanSortedAssoc($planovaneKurzy);
            foreach ($aktivity as $indexAktivity=>$aktivita) {
                $planKurz = $planSortedAssoc[$indexAktivity] ?? null;
                $aktivitaPlan = self::createAktivitaPlan($planKurz, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
                if ($aktivitaPlan) {
                    $id++;
                    $kolekce[$indexAktivity] = $aktivitaPlan;
                }
            }
        } else {
            $kolekce = array();
        }
        return $kolekce;
    }

    /**
     *
     * @param Projektor2_Model_Db_Flat_ZaPlanFlatTable $plan
     * @param Projektor2_Model_Db_Flat_ZaUkoncFlatTable $ukonceni
     * @param type $aktivita
     * @param type $indexAktivity
     * @param type $id
     * @param type $zajemce
     * @return \Projektor2_Model_AktivitaPlan
     */
//    private static function creaAktivitaPlan(Projektor2_Model_Db_Flat_ZaPlanFlatTable $plan, Projektor2_Model_Db_Flat_ZaUkoncFlatTable $ukonceni,
//            $aktivita, $indexAktivity, $id, $zajemce) {
//        if ($aktivita['typ']=='kurz') {
//            $columnsPlan = $plan->getItemColumnsNames($indexAktivity);
//            $columnsUkonceni = $ukonceni->getItemColumnsNames($indexAktivity);
//            $sKurz = Projektor2_Model_Db_SKurzMapper::get($plan->{$columnsPlan['idSKurzFK']});
//            if ($sKurz) {
//                $certifikatyKurz = Projektor2_Model_Db_CertifikatKurzMapper::find($zajemce, $sKurz, FALSE);  // všechny typy certifikátu
//            } else {
//                $certifikatyKurz = [];
//            }
//            return new Projektor2_Model_AktivitaPlan($id, $indexAktivity, $aktivita['nadpis'], $aktivita['s_certifikatem'],
//                    $aktivita['tiskni_certifikat'], $aktivita['tiskni_certifikat_monitoring'],
//                    $sKurz,
//                    $plan->{$columnsPlan['pocAbsHodin']}, $plan->{$columnsPlan['duvodAbsence']}, $plan->{$columnsPlan['dokonceno']},
//                    $plan->{$columnsPlan['duvodNeukonceni']}, $plan->{$columnsPlan['datumCertif']},
//                    $certifikatyKurz,
//                    $ukonceni->{$columnsUkonceni['hodnoceni']});
//        }
//    }

    private static function getPlanSortedAssoc($planovaneKurzy) {
        /** @var Projektor2_Model_Db_ZaPlanKurz[] $planovaneKurzy */
        foreach ($planovaneKurzy as $planKurz) {
            $planSortedAssoc[$planKurz->kurz_typ_fk.$planKurz->poradi] = $planKurz;
        }
        return $planSortedAssoc;
    }

    private static function createAktivitaPlan(Projektor2_Model_Db_ZaPlanKurz $planKurz=null, Projektor2_Model_Db_Flat_ZaUkoncFlatTable $ukonceni,
            $aktivita, $indexAktivity, $id, $zajemce) {

        if ($aktivita['typ']=='kurz') {

            $columnsUkonceni = $ukonceni->getItemColumnsNames($indexAktivity);
            $sKurz = Projektor2_Model_Db_SKurzMapper::get($planKurz->id_s_kurz_FK);
            if ($sKurz) {
                $certifikatyKurz = Projektor2_Model_Db_CertifikatKurzMapper::find($zajemce, $sKurz, FALSE);  // všechny typy certifikátu
            } else {
                $certifikatyKurz = [];
            }
            return new Projektor2_Model_AktivitaPlan($id, $indexAktivity, $aktivita['nadpis'], $aktivita['s_certifikatem'],
                    $aktivita['tiskni_certifikat'], $aktivita['tiskni_certifikat_monitoring'],
                    $sKurz,
                    $planKurz->poc_abs_hodin, $planKurz->duvod_absence, $planKurz->dokonceno,
                    $planKurz->duvod_neukonceni, $planKurz->datum_certif,
                    $certifikatyKurz,
                    $ukonceni->{$columnsUkonceni['hodnoceni']});
        }
    }
}
