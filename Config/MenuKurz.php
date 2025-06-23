<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MenuKurz
 *
 * @author pes2704
 */
class Config_MenuKurz {

    /**
     * Nastaví skupiny tlačítek ke kurzu
     *
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return type
     * @throws UnexpectedValueException
     */
    public static function setSkupinyKurz(Projektor2_Viewmodel_KurzViewmodel $viewmodelKurz, $planCount) {
        $sessionStatus = Projektor2_Model_Status::getSessionStatus();
        $user = $sessionStatus->getUserStatus()->getUser();

                //kurz
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoKurz();
                    $modelTlacitko->kurz = 'detail_kurzu';
                    $modelTlacitko->text = 'Detail kurzu';
                    $modelTlacitko->title = 'Úprava údajů kurzu';

                    $modelTlacitko->status = 'edit';
                $skupina->addButton($modelTlacitko);
                if (count($skupina->getButtons())) {
                    $viewmodelKurz->addGroup('detail', $skupina);
                }
                //účastníci
                $skupina = new Projektor2_Viewmodel_Menu_Group();
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoKurz();
                    $modelTlacitko->kurz = 'ucastnici_kurzu';
                    $modelTlacitko->text = 'Účastníci';
                    $modelTlacitko->title = 'Seznam účastníků kurzu';
                    $modelTlacitko->status = 'print';
                $skupina->addButton($modelTlacitko);


                if (count($skupina->getButtons())) {
                    $viewmodelKurz->addGroup('ucastnici', $skupina);
                    $modelSignal = new Projektor2_Viewmodel_Menu_SignalKurz_Ucastnici();
                    $modelSignal->setByPlanKurzArray($planCount);
                    $skupina->addSignal($modelSignal);
                }


        return $viewmodelKurz;
    }
}
