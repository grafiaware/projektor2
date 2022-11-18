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
    public static function setSkupinyKurz(Projektor2_Viewmodel_Kurz $viewmodelKurz, Projektor2_Model_Db_SKurz $sKurz) {
        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $user = $sessionStatus->user;

                //kurz
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoKurz();
                    $modelTlacitko->kurz = 'detail_kurzu';
                    $modelTlacitko->text = 'Detail kurzu';
                    $modelTlacitko->title = 'Úprava údajů kurzu';

                    $modelTlacitko->status = 'edit';
                $skupina->setMenuTlacitko($modelTlacitko);
                if (count($skupina->getMenuTlacitka())) {
                    $viewmodelKurz->setSkupina('detail', $skupina);
                }
                //účastníci
                $skupina = new Projektor2_Viewmodel_Menu_Skupina();
                    $modelTlacitko = new Projektor2_Viewmodel_Menu_TlacitkoKurz();
                    $modelTlacitko->kurz = 'ucastnici_kurzu';
                    $modelTlacitko->text = 'Účastníci';
                    $modelTlacitko->title = 'Seznam účastníků kurzu';
                    $modelTlacitko->status = 'print';
                $skupina->setMenuTlacitko($modelTlacitko);


                if (count($skupina->getMenuTlacitka())) {
                    $viewmodelKurz->setSkupina('ucastnici', $skupina);
                    $zaPlanKurzArray = Projektor2_Model_Db_ZaPlanKurzMapper::findAll("id_s_kurz_FK={$sKurz->id_s_kurz}");
                    $modelSignal = new Projektor2_Viewmodel_Menu_SignalKurz_Ucastnici();
                    $modelSignal->setByPlanKurzArray($zaPlanKurzArray);
                    $skupina->setMenuSignal($modelSignal);
                }


        return $viewmodelKurz;
    }
}