<?php

/**
 * Description of Aktivity
 *
 * @author pes2704
 */
class Config_Aktivity {

    const TYP_KURZ = 'kurz';
    const TYP_PORADENSTVI = self::TYP_PORADENSTVI;

    public static function findAktivity($projektKod, $aktivitaTyp) {
        $kurzyProjektu = [];
        foreach (self::getAktivityProjektu($projektKod) as $druhAktivity => $aktivita) {
            if ($aktivita['typ']==$aktivitaTyp) {
                $kurzyProjektu[$druhAktivity] = $aktivita;
            }
        }
        return $kurzyProjektu;
    }

    public static function findAktivityPodleKurzDruh($projektKod, $aktivitaTyp, $aktivitaKurzDruh) {
        $kurzyProjektu = [];
        foreach (self::getAktivityProjektu($projektKod) as $druhAktivity => $aktivita) {
            if ($aktivita['typ']==$aktivitaTyp AND $aktivita['kurz_druh']==$aktivitaKurzDruh) {
                $kurzyProjektu[$druhAktivity] = $aktivita;
            }
        }
        return $kurzyProjektu;
    }
    
############# AKTIVITY PROJEKTU #############
    /**
     * Vrací pole pro formuláře IP projektu
     * @param string $kod Kód projektu
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getAktivityProjektu($kod=NULL) {
        switch ($kod) {
        ######## AP #################
            case 'AP':
    $aktivity = array(
            'zztp'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'ZZTP',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz základních znalostí trhu práce',
                's_hodnocenim' => FALSE,
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('mot')
                ),
            'fg'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'FG',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz finanční gramotnosti',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'PC',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz komunikace včetně obsluhy PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('pc')
                ),
            'im'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'IM',
                'vyberovy'=> 1,
                'nadpis'=>'Image poradna',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Image poradna'
                ),
            'spp'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'SPP',
                'vyberovy'=> 1,
                'nadpis'=>'Motivační setkání pro podnikavé',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Motivační setkání pro podnikavé'
                ),
            'sebas'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'SEBAS',
                'vyberovy'=> 1,
                'nadpis'=>'Podpora sebevědomí a asertivita',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Podpora sebevědomí a asertivita'
                ),
            'forpr'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'FORPR',
                'vyberovy'=> 1,
                'nadpis'=>'Moderní formy práce',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Moderní formy práce'
                ),
            'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'PD',
                'vyberovy'=> 1,
                'nadpis'=>'Pracovní diagnostika',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Pracovní diagnostika'
                ),
            'porad'=>array(
                'typ'=>self::TYP_PORADENSTVI,
                'vyberovy'=> 0,
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání',
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                ),
            'klub'=>array(
                'typ'=>self::TYP_PORADENSTVI,
                'vyberovy'=> 1,
                'nadpis'=>'Klubová setkání',
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                ),
            'vyhodnoceni'=>array(
                'typ'=>self::TYP_PORADENSTVI,
                'vyberovy'=> 0,
                'nadpis'=>'Vyhodnovení účasti při ukončení účasti',
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                ),
            'doporuceni'=>array(
                'typ'=>self::TYP_PORADENSTVI,
                'vyberovy'=> 0,
                'nadpis'=>'Doporučení vysílajícímu KoP ÚP při ukončení účasti',
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                )
            );

                break;
        ######## HELP #################
            case 'HELP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Motivační kurz',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'prof2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'prof3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 3',
                'kurz_druh'=>'RK',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'im'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Image poradna',
                'kurz_druh'=>'IM',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Image poradna'
                ),
            'spp'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Setkání pro podnikavé',
                'kurz_druh'=>'SPP',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Setkání pro podnikavé'),
            'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                ),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                )
            );
                break;
        ######## SJZP #################
            case 'SJZP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Motivační kurz',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('rk')
                ),
        // prof3 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('jaz')
                ),
            'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'SJZP Pracovní diagnostika'),
            'bidi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Bilanční diagnostika',
                'kurz_druh'=>'BD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'SJZP Bilanční diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
            ),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>self::getHelp('poradenstvi')
            )
        );
                break;
        ######## VZP #################
            case 'VZP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>self::getHelp('mot')
                )
            );
                break;
        ######## SJZP PK KK #################
            case 'SJPK':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz dovedností pro pracovní trh',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
        // prof2 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
            'prof3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'prof4'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
                'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                ),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenstvi')
                )
            );
                break;
        ######## ZPM #################
            case 'ZPM':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>self::getHelp('mot')
                )
            );
                break;
     ######## SPP #################
            case 'SPP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>self::getHelp('mot')
                )
            );
                break;
     ######## VDTP #################
            case 'VDTP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>self::getHelp('mot')
                )
            );
                break;
     ######## PDU #################
            case 'PDU':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>self::getHelp('mot')
                )
            );
                break;



    ######## RP #################
            case 'RP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'tiskni_certifikat_monitoring' => TRUE,
                'help'=>self::getHelp('mot')
                ),
        // prof1 je použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof1
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Jazykový lurz - jazyk anglickýa',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                )
            );
                break;
        ######## SJPO V PLZNI A OKOLÍ #################
            case 'SJPO':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz dovedností pro pracovní trh',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
        // prof2 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
            'prof3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'prof4'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'odb1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Odborný kurz 1',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('odb')
                ),
            'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenstvi')
            ),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenstvi')
            )
        );
                break;
        ######## SJLP Pro LEPŠÍ PRÁCI #################
            case 'SJLP':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz dovedností pro pracovní trh',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
        // prof2 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
            'prof3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'prof4'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'odb1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Odborný kurz 1',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('odb')
                ),
                'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenství')
            ),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenství')
                )
            );
                break;
        ######## MOJE BUDOUCNOST #################
            case 'MB':

    $aktivity = array(
            'zztp'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Kurz dovedností pro trh práce a motivační aktivity',
                'kurz_druh'=>'ZZTP',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('mot')
                ),
            'fg'=>array(
                'typ'=>self::TYP_KURZ,
                'kurz_druh'=>'FG',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz finanční gramotnosti',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('mot')
                ),
            'pc1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'pc2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'PC kurz doplňkový',
                'kurz_druh'=>'PC',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('pc')
                ),
            'prof1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz s jazykem',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
        // prof2 je v MB použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof2
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Intenzivní kurz odborného jazyka',
                'kurz_druh'=>'JAZ',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ),
            'prof3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 1',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'prof4'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Rekvalifikační kurz 2',
                'kurz_druh'=>'RK',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('rk')
                ),
            'odb1'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Odborný kurz 1',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('odb')
                ),
            'odb2'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Odborný kurz 2',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('odb')
                ),
            'odb3'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Odborný kurz 3',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('odb')
                ),
            'odb4'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Odborný kurz 4',
                'kurz_druh'=>'ODB',
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('odb')
            ),


            'prdi'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Pracovní diagnostika',
                'kurz_druh'=>'PD',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>'SJPK Pracovní diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Zprostředkování práce/Umisťování na pracovní místa',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenství')
            ),
            'doporuceni'=>array(
                'typ'=>'poradenství',
                'nadpis'=>'Doporučení',
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('poradenství')
            )
        );
                break;
        ######## ČEŠTINA PRO CIZINCE #################
            case 'CJC':

    $aktivity = [

        'prof1'=> [
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Český jazyk pro cizince A1',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'certifikat' => self::getCertifikatParams('o'),
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ],
            'prof2'=>[
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Český jazyk pro cizince A1',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'certifikat' => self::getCertifikatParams('o'),
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ],
            'prof3'=>[
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Český jazyk pro cizince A2',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'certifikat' => self::getCertifikatParams('o'),
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ],
            'prof4'=>[
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Český jazyk pro cizince A2',
                'kurz_druh'=>'RKJAZ',
                's_certifikatem' => TRUE,
                'certifikat' => self::getCertifikatParams('o'),
                's_hodnocenim' => FALSE,
                'help'=>self::getHelp('jaz')
                ],
        ];
                break;
            case 'CKP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program',
                'kurz_druh'=>'MOT',
                's_certifikatem' => TRUE,
                'certifikat' => self::getCertifikatParams('o+m'),
                'help'=>self::getHelp('mot')
                )
            );
                break;
            case 'PKP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>self::TYP_KURZ,
                'nadpis'=>'Poradenský program pro podnikání',
                'kurz_druh'=>'POD',
                's_certifikatem' => TRUE,
                'certifikat' => self::getCertifikatParams('o+m'),
                'help'=>self::getHelp('mot')
                )
            );
                break;

            default:
        throw new UnexpectedValueException("Neexistuje konfigurace pro daný kód projektu: $kod");
        };
    return $aktivity;
    }

    private static function getCertifikatParams($certType) {
        switch ($certType) {
            case 'o':
                $params = [
                    'original' => true,
                    'pseudokopie' => false,
                    'monitoring' => false,
                ];
                break;
            case 'o+p':
                $params = [
                    'original' => true,
                    'pseudokopie' => true,
                    'monitoring' => false,
                ];
                break;
            case 'o+m':
                $params = [
                    'original' => true,
                    'pseudokopie' => false,
                    'monitoring' => true,
                ];
                break;
            default:
                $params = [];
        }
        return $params;
    }

    protected static function getHelp($druh) {
        switch ($druh) {
        case 'mot':
            $help =
        'Příklady známek a slovního zhodnocení Motivačního programu<br>
            1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
            2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
            3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
        ;
            break;

        case 'pc':
            $help =
            'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
                1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br>
                3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
                5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ;
        case 'rk':
            $help=
            'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
                Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
                1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
                2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
                3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
                5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
            ;
            break;
        case 'odb':
            $help=
            'Příklady známek a slovního zhodnocení odborného kurzu<br>
                Odborné kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
                1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Odborný kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající kvalifikaci.<br>
                2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
                3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
                5 = Účastník pasivně přistupoval k výběru vhodného kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
            ;
            break;
        case 'jaz':
            $help =
            'Příklady známek a slovního zhodnocení jazykového kurzu<br>
                Jazykové kurzy <br>
                1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
                2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání.
                Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
                3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru.
                Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
                Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
                5 = Účastník pasivně přistupoval k výběru vhodného kurzu odborného jazyka. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
;
        case 'poradenstvi':
            $help =
            'Příklady známek a slovního zhodnocení<br>
                1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
                2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
                3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
                4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
                5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'
            ;

            break;
        default:
            break;
        }
    }
}
