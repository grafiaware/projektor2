<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Signal_Plan extends Projektor2_Viewmodel_Menu_Signal {

    public function setByAktivitaPlan($aktivita, $kurz=null) {
//            'zztp'=>array(
//                'typ'=>self::TYP_KURZ,
//                'kurz_druh'=>'ZZTP',
//                'vyberovy'=> 0,
//                'nadpis'=>'Kurz základních znalostí trhu práce',
//                's_hodnocenim' => FALSE,
//                's_certifikatem' => TRUE,
//                'certifikat' => self::getCertifikatParams('o'),
//                'tiskni_certifikat' => TRUE,
//                'help'=>self::getHelp('mot')
//                ),        
        if (isset($kurz)) {
            /** @var Projektor2_Model_Db_ZaPlanKurz $kurz */
            if (Config_AppContext::isVerboseMode()) {
                $this->text = $kurz->kurz_druh_fk." ".$kurz->id_s_kurz_FK;
            } else {
                $this->text = $kurz->kurz_druh_fk;
            }        
            
            if ($kurz->date_certif) {  //ma certifikat kurz
                $this->status = 'uspesneSCertifikatem';
            } elseif ($kurz->dokonceno=='Ano' AND !$aktivita['s_certifikatem']) {
                $this->status = 'uspesne';
            } elseif ($kurz->dokonceno=='Ano' AND $aktivita['s_certifikatem']) {
                $this->status = 'uspesneCekaNaCertifikat';
            } elseif ($kurz->dokonceno=='Ne') {
                $this->status = 'neuspesne';
            } else {
                $this->status = 'plan';
            }
        } else {
            $this->text = '.';
            $this->status = 'none';
        }
    }
}
