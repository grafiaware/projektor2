<?php
/**
 * Description of Projektor2_Model_KurzPlanMapper
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_AktivityPlanMapper {

    public static function findByIndexAktivity($indexAktivity) {
        $sessionStatus = Projektor2_Model_Status::getSessionStatus();
        $aktivity = Config_Aktivity::getAktivityProjektu($sessionStatus->getUserStatus()->getProjekt()->kod);
        $kurzPlan = NULL;
        if ($aktivity) {
            $idZajemce = $sessionStatus->getUserStatus()->getZajemce()->id;
            $planovaneKurzy = Projektor2_Model_Db_ZaPlanKurzMapper::findAllForZajemce($idZajemce);  // where zajemce AND $indexAktivity=aktivita
            $planSortedAssoc = self::sortAndAssocToActivity($planovaneKurzy);
            $aktivita = $aktivity[$indexAktivity];
            $planKurz = $planSortedAssoc[$indexAktivity] ?? null;
            $aktivitaPlan = self::createAktivitaPlan($planKurz, $aktivita, $indexAktivity, 1, $idZajemce);
        }
        return $aktivitaPlan;
    }

    /**
     * Vrací pole modelů Projektor2_Model_AktivitaPlan pro všechny aktivity projektu i nenaplánované
     *
     * @param int $idZajemce
     * @param type $typAktivity
     * @return \Projektor2_Viewmodel_AktivitaPlan array
     */
    public static function findAll($idZajemce, $typAktivity=NULL) {
        $sessionStatus = Projektor2_Model_Status::getSessionStatus();
        $aktivity = Config_Aktivity::getAktivityProjektu($sessionStatus->getUserStatus()->getProjekt()->kod);
        $kolekce = array();
        if ($aktivity) {
            $id = 0;
            $planovaneKurzy = Projektor2_Model_Db_ZaPlanKurzMapper::findAllForZajemce($idZajemce);   // SELECT * FROM za_plan_kurz
            $planSortedAssoc = self::sortAndAssocToActivity($planovaneKurzy);
            foreach ($aktivity as $indexAktivity=>$aktivita) {
                $planKurz = $planSortedAssoc[$indexAktivity] ?? null;
                $aktivitaPlan = self::createAktivitaPlan($planKurz, $aktivita, $indexAktivity, $id, $idZajemce);
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
     * @param Projektor2_Model_Status $sessionStatus
     * @param int $idZajemce
     * @param type $typAktivity
     * @return \Projektor2_Viewmodel_AktivitaPlan array
     */
    public static function findAllAssoc($idZajemce, $typAktivity=NULL) {
        $sessionStatus = Projektor2_Model_Status::getSessionStatus();
        $aktivity = Config_Aktivity::getAktivityProjektu($sessionStatus->getUserStatus()->getProjekt()->kod);  // nejen kurzy
        $kolekce = array();
        if ($aktivity) {
            $id = 0;
            $planovaneKurzy = Projektor2_Model_Db_ZaPlanKurzMapper::findAllForZajemce($idZajemce); // ORDER BY kurz_druh_fk ASC, aktivita ASC
            $planSortedAssoc = self::sortAndAssocToActivity($planovaneKurzy);  // itemy ZaPlanKurz v assoc oli indexované podle aktivita (prof1, prof2, ...)
            foreach ($aktivity as $indexAktivity=>$aktivita) {
                $planKurz = $planSortedAssoc[$indexAktivity] ?? null;
                $aktivitaPlan = self::createAktivitaPlan($planKurz, $aktivita, $indexAktivity, $id, $idZajemce);  // znovu se čte sKurz (a poprvé certifikát)
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

    private static function sortAndAssocToActivity($planovaneKurzy) {
        /** @var Projektor2_Model_Db_ZaPlanKurz[] $planovaneKurzy */
        foreach ($planovaneKurzy as $planKurz) {
            $planSortedAssoc[$planKurz->aktivita] = $planKurz;
        }
        return $planSortedAssoc;
    }

    private static function createAktivitaPlan(Projektor2_Model_Db_ZaPlanKurz $planKurz=null,
            $aktivita, $indexAktivity, $id, $idZajemce) {

        if ($aktivita['typ']==Config_Aktivity::TYP_KURZ) {     // $planKurz nemá date_certif
            $sKurz = Projektor2_Model_Db_SKurzMapper::get($planKurz->id_s_kurz_FK);
            if ($sKurz) {
                $certifikatyKurz = Projektor2_Model_Db_CertifikatKurzMapper::find($idZajemce, $sKurz->id_s_kurz, FALSE);  // všechny typy certifikátu
            } else {
                $certifikatyKurz = [];
            }
            return new Projektor2_Viewmodel_AktivitaPlan(
                    $id,
                    $indexAktivity,
                    $aktivita['nadpis'], $aktivita['s_certifikatem'],
                    new Projektor2_Viewmodel_AktivitaPlanCertifikatParams(
                            $aktivita['certifikat']['original'] ?? false,
                            $aktivita['certifikat']['pseudokopie'] ?? false,
                            $aktivita['certifikat']['monitoring'] ?? false
                            ),
                    $planKurz,
                    $sKurz,
                    $certifikatyKurz);
        }
    }
}
