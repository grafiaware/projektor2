<?php
/**
 * Description of Form
 *
 * @author pes2704
 */
class Projektor2_Router_Form {

    protected $sessionStatus;
    protected $request;
    protected $response;

    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getController() {
        $form = $this->request->get('form');
        $kodProjektu = $this->sessionStatus->projekt->kod;
        switch ($kodProjektu) {
            case 'AGP':
                /** AGP **/
                switch($form) {
                    case "agp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Agp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "agp_reg_dot":
                        return new Projektor2_Controller_Formular_Agp_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "agp_sml_uc":
                        return new Projektor2_Controller_Formular_Agp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "agp_souhlas_uc":
                        return new Projektor2_Controller_Formular_Agp_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'HELP':
                /** HELP **/
                switch($form) {
                   case "he_novy_zajemce":
                        return new Projektor2_Controller_Formular_Help_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "he_reg_dot":
                        return new Projektor2_Controller_Formular_Help_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "he_sml_uc":
                        return new Projektor2_Controller_Formular_Help_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "he_souhlas_uc":
                        return new Projektor2_Controller_Formular_Help_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "he_plan_uc":
                        return new Projektor2_Controller_Formular_Help_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "he_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Help_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'AP':
                /** AP **/
                switch($form) {
                   case "ap_novy_zajemce":
                        return new Projektor2_Controller_Formular_Ap_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_reg_dot":
                        return new Projektor2_Controller_Formular_Ap_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "ap_sml_uc":
                        return new Projektor2_Controller_Formular_Ap_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "ap_souhlas_uc":
                        return new Projektor2_Controller_Formular_Ap_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "ap_ip1_uc":
                        return new Projektor2_Controller_Formular_Ap_IP0($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_plan_uc":
                        return new Projektor2_Controller_Formular_Ap_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_porad_uc":
                        return new Projektor2_Controller_Formular_Ap_IPPoradenstvi($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Ap_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "ap_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Ap_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'SJZP':
                /** SJZP **/
                switch($form) {
                   case "sjzp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Sjzp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjzp_reg_dot":
                        return new Projektor2_Controller_Formular_Sjzp_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "sjzp_sml_uc":
                        return new Projektor2_Controller_Formular_Sjzp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "sjzp_souhlas_uc":
                        return new Projektor2_Controller_Formular_Sjzp_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjzp_plan_uc":
                        return new Projektor2_Controller_Formular_Sjzp_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjzp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjzp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjzp_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjzp_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'VZP':
                /** VZP **/
                switch($form) {
                   case "vzp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Vzp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "vzp_sml_uc":
                        return new Projektor2_Controller_Formular_Vzp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "vzp_plan_uc":
                        return new Projektor2_Controller_Formular_Vzp_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "vzp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Vzp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

            case 'ZPM':
                /** ZPM **/
                switch($form) {
                    case "zpm_novy_zajemce":
                        return new Projektor2_Controller_Formular_Zpm_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zpm_sml_uc":
                        return new Projektor2_Controller_Formular_Zpm_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zpm_plan_uc":
                        return new Projektor2_Controller_Formular_Zpm_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zpm_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Zpm_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'SPP':
                /** SPP**/
                switch($form) {
                   case "spp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Spp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "spp_sml_uc":
                        return new Projektor2_Controller_Formular_Spp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "spp_plan_uc":
                        return new Projektor2_Controller_Formular_Spp_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "spp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Spp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'RP':
                /** RP**/
                switch($form) {
                   case "rp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Rp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "rp_sml_uc":
                        return new Projektor2_Controller_Formular_Rp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "rp_plan_uc":
                        return new Projektor2_Controller_Formular_Rp_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "rp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Rp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

            case 'SJPK':
                /** SJPK **/
                switch($form) {
                   case "sjpk_novy_zajemce":
                        return new Projektor2_Controller_Formular_Sjpk_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpk_reg_dot":
                        return new Projektor2_Controller_Formular_Sjpk_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "sjpk_sml_uc":
                        return new Projektor2_Controller_Formular_Sjpk_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "sjpk_souhlas_uc":
                        return new Projektor2_Controller_Formular_Sjpk_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpk_plan_uc":
                        return new Projektor2_Controller_Formular_Sjpk_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpk_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjpk_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpk_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjpk_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

            case 'SJPO':
                /** SJPO **/
                switch($form) {
                    case "sjpo_novy_zajemce":
                        return new Projektor2_Controller_Formular_Sjpo_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_reg_dot":
                        return new Projektor2_Controller_Formular_Sjpo_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_sml_uc":
                        return new Projektor2_Controller_Formular_Sjpo_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_souhlas_uc":
                        return new Projektor2_Controller_Formular_Sjpo_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_plan_uc":
                        return new Projektor2_Controller_Formular_Sjpo_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjpo_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjpo_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr routeru form \"'.$form.'\" v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

            case 'SJLP':
                /** SJLP **/
                switch($form) {
                    case "sjlp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Sjlp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjlp_reg_dot":
                        return new Projektor2_Controller_Formular_Sjlp_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjlp_sml_uc":
                        return new Projektor2_Controller_Formular_Sjlp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjlp_souhlas_uc":
                        return new Projektor2_Controller_Formular_Sjlp_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjlp_plan_uc":
                        return new Projektor2_Controller_Formular_Sjlp_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjlp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjlp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjlp_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjlp_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr routeru form \"'.$form.'\" v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

            case 'VDTP':
                /** VDTP**/
                switch($form) {
                   case "vdtp_novy_zajemce":
                        return new Projektor2_Controller_Formular_Vdtp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "vdtp_sml_uc":
                        return new Projektor2_Controller_Formular_Vdtp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "vdtp_plan_uc":
                        return new Projektor2_Controller_Formular_Vdtp_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "vdtp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Vdtp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

           case 'PDU':
                /** PDU **/
                switch($form) {
                   case "pdu_novy_zajemce":
                        return new Projektor2_Controller_Formular_Pdu_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "pdu_sml_uc":
                        return new Projektor2_Controller_Formular_Pdu_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "pdu_plan_uc":
                        return new Projektor2_Controller_Formular_Pdu_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "pdu_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Pdu_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;

            case 'MB':
                /** MB **/
                switch($form) {
                    case "mb_novy_zajemce":
                        return new Projektor2_Controller_Formular_Mb_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "mb_reg_dot":
                        return new Projektor2_Controller_Formular_Mb_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "mb_sml_uc":
                        return new Projektor2_Controller_Formular_Mb_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "mb_souhlas_uc":
                        return new Projektor2_Controller_Formular_Mb_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "mb_plan_uc":
                        return new Projektor2_Controller_Formular_Mb_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "mb_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Mb_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "mb_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Mb_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr routeru form \"'.$form.'\" v projektu '.$this->sessionStatus->projekt->kod);
                }
                break;
            case 'CJC':
                /** CJC **/
                switch($form) {
                    case "cj_novy_zajemce":
                        return new Projektor2_Controller_Formular_Cjc_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cj_reg_dot":
                        return new Projektor2_Controller_Formular_Cjc_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cj_sml_uc":
                        return new Projektor2_Controller_Formular_Cjc_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cj_souhlas_uc":
                        return new Projektor2_Controller_Formular_Cjc_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cj_plan_uc":
                        return new Projektor2_Controller_Formular_Cjc_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cj_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Cjc_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cj_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Cjc_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException("Router ".get_called_class()." - Neznámý parametr předaný routeru '$form' v projektu $kodProjektu.");
                }
                break;


            default:
                throw new UnexpectedValueException('Neznámý kód projektu: '.$this->sessionStatus->projekt->kod);
        }

    /** STARÉ PROJEKTY **/
    //        case "zobraz_reg":
    //            include INC_PATH."ind_zobraz_reg.inc";
    //            break;
    //        case "zobraz_uc":
    //            setcookie("id_ucastnik",$_GET['id_ucastnik']);
    //            if ($_GET['save']) include INC_PATH.'ind_save_form';
    //            include INC_PATH."ind_reg_dot.inc";
    //            break;
    //        case "reg_dot":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_form.inc';
    //            include INC_PATH."ind_reg_dot.inc";
    //            break;
    //        case "sml_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_form.inc';
    //            include INC_PATH."ind_sml_uc.inc";
    //            break;
    //        case "ind_plan_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_plan_uc.inc';
    //            include INC_PATH."ind_plan_uc.inc";
    //            //include INC_PATH."ind_kolize_kterenejsouveskriptuvolane_uc.inc"; //tady nelze, protoze nejde ulozit sloupecky revidovano
    //            break;
    //        case "testpc_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) {
    //                    include INC_PATH.'ind_save_testpc_uc.inc';
    //                    include INC_PATH."ind_zobraz_reg.inc";
    //            } else {
    //                    include INC_PATH."ind_testpc_uc.inc";
    //            }
    //            break;
    //        case "doprk_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc.inc";
    //            break;
    //        case "doprk_dopl1":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_dopl1.inc";
    //            break;
    //        case "doprk_dopl2":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_dopl2.inc";
    //            break;
    //        case "doprk_dopl3":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_dopl3.inc";
    //            break;
    //        case "doprk_vyraz":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_doprk_uc.inc';
    //            include INC_PATH."ind_doprk_uc_vyraz.inc";
    //            break;
    //        case "ukonceni_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_ukonc_uc.inc';
    //            include INC_PATH."ind_ukonc_uc.inc";
    //            break;
    //        case "zam_uc":
    //            setcookie("id_ucastnik");
    //            if ($_GET['save']) include INC_PATH.'ind_save_zam_uc.inc';
    //            include INC_PATH."ind_zam_uc.inc";
    //            break;
    //        case "zobraz_reg_export":
    //            include INC_PATH."ind_zobraz_reg.inc";  //v ind_zobraz_reg.inc na konci proběhne export do excelu
    //            break;
    //        case "zobraz_reg_vahy":
    //            include INC_PATH."ind_zobraz_reg.inc";  //v ind_zobraz_reg.inc na konci proběhne vypocet a zapis do db
    //            break;
    //        case "zobraz_stat":
    //            include INC_PATH."ind_zobraz_stat.inc";
    //            break;
    //        case "uloz_vyplnil_stat":
    //            include INC_PATH."set_stat_form_fill.inc";
    //            include INC_PATH."ind_zobraz_stat.inc";
    //            break;
    //        case "zarad_agp_uc":
    //            setcookie("id_ucastnik");
    //            include INC_PATH."ind_zarad_do_agp.inc";
    //            include INC_PATH."ind_zobraz_reg.inc";
    //            break;
    //
    }
}

