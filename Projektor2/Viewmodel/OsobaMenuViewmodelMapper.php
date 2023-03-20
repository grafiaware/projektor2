<?php
class Projektor2_Viewmodel_OsobaMenuViewmodelMapper {
    /**
     * Metoda vyhledá a vytvoří model podle id tabulky zajemce. Id modelu je shodné z id zajemce.
     * @param integer $id
     * @return Projektor2_Viewmodel_OsobaMenuViewmodel
     */
    public static function findById($id) {
        $zajemce = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findById($id);
        return self::create($zajemce);
    }

    public static function find($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE) {
        $zajemci = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::find($filter, $filterBindParams, $order, $findInvalid);
        if ($zajemci) {
            foreach ($zajemci as $zajemce) {
                $zajemciRegistrace[] = self::create($zajemce);
            }
        } else {
            return array();
        }
        return $zajemciRegistrace;
    }

    public static function findInContext($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $zajemci = Projektor2_Model_Db_Read_ZajemceOsobniUdajeMapper::findInContext($filter, $filterBindParams, $order, $findInvalid, $findOutOfContext);
        $zajemciRegistrace = [];
        foreach ($zajemci as $zajemce) {
            $zajemciRegistrace[] = self::create($zajemce);
        }
        return $zajemciRegistrace;
    }

    public static function create(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $osobaMenuViewModel =  new Projektor2_Viewmodel_OsobaMenuViewmodel($zajemceDbReadOsobniUdaje);
        // nastaví skupiny objeku zajemceRegistrace
        Config_MenuOsoba::setSkupinyZajemce($osobaMenuViewModel);
        foreach ($osobaMenuViewModel->getGroups() as $groupName=>$group) {
            switch ($groupName) {
                case Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_CIZINEC:
                    self::addSignalsCizinec($group, $zajemceDbReadOsobniUdaje);
                    break;
                case Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_PLAN:
                    self::addSignalsPlan($group, $zajemceDbReadOsobniUdaje);
                    break;
                case Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_UKONCENI:
                    self::addSignalsUkonceni($group, $zajemceDbReadOsobniUdaje);
                    break;
                case Projektor2_Viewmodel_OsobaMenuViewmodel::GROUP_ZAMESTNANI:
                    self::addSignalsZamestnani($group, $zajemceDbReadOsobniUdaje);
                    break;
                default:
                    break;
            }
        }
        return $osobaMenuViewModel;
    }

    ######### PRIVATE #######################

    private static function addSignalsCizinec(Projektor2_Viewmodel_Menu_Group $group, Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Registrace();
        $modelSignal->setByDbReadOsobniUdaje($zajemceDbReadOsobniUdaje);
        $group->addSignal($modelSignal);
    }

    private static function addSignalsPlan(Projektor2_Viewmodel_Menu_Group $group, Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $kolekceAktivityPlan = Projektor2_Viewmodel_AktivityPlanMapper::findAll($zajemceDbReadOsobniUdaje->id);
        if ($kolekceAktivityPlan) {
            foreach ($kolekceAktivityPlan as $aktivitaPlan) {
                /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
                $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Plan();
                $modelSignal->setByAktivitaPlan($aktivitaPlan);
                $group->addSignal($modelSignal);
            }
        }
    }

    private static function addSignalsUkonceni(Projektor2_Viewmodel_Menu_Group $skupina, Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Ukonceni();
        // použij CollectionFlatTable
        $modelSignal->setByUkonceni($zajemceDbReadOsobniUdaje);
        $skupina->addSignal($modelSignal);
    }

    private static function addSignalsZamestnani(Projektor2_Viewmodel_Menu_Group $skupina, Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $modelSignal = new Projektor2_Viewmodel_Menu_Signal_Zamestnani();
        // použij CollectionFlatTable
        $modelSignal->setByZamestnani($zajemceDbReadOsobniUdaje);
        $skupina->addSignal($modelSignal);
    }
}
