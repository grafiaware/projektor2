<?php
/**
 * Description of Form
 *
 * @author pes2704
 */
class Projektor2_Router_Form {

    const CTRL_NOVA_OSOBA = "novy_zajemce";
    const CTRL_CIZINEC = "cizinec";
    const CTRL_SMLOUVA = "smlouva";
    const CTRL_SOUHLAS = "souhlas";
    const CTRL_PLAN = "plan";
    const UKONCENI = "ukonceni";
    const CTRL_ZAMESTNANI = "zamestnani";

    protected $sessionStatus;
    protected $request;
    protected $response;

    public function __construct(Projektor2_Model_Status $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getResult() {
        $form = $this->request->get('form');
        $kodProjektu = $this->sessionStatus->getUserStatus()->getProjekt()->kod;
        switch ($kodProjektu) {
            case 'AGP':
                /** AGP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'HELP':
                /** HELP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                   case "he_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Help_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'AP':
                /** AP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
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
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'SJZP':
                /** SJZP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "sjzp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjzp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjzp_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjzp_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'VZP':
                /** VZP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Vzp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "vzp_sml_uc":
                        return new Projektor2_Controller_Formular_Vzp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "vzp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Vzp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

            case 'ZPM':
                /** ZPM **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Zpm_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zpm_sml_uc":
                        return new Projektor2_Controller_Formular_Zpm_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "zpm_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Zpm_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'SPP':
                /** SPP**/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Spp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "spp_sml_uc":
                        return new Projektor2_Controller_Formular_Spp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "spp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Spp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'RP':
                /** RP**/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Rp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "rp_sml_uc":
                        return new Projektor2_Controller_Formular_Rp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "rp_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Rp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

            case 'SJPK':
                /** SJPK **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                    case "plan":
                        return new Projektor2_Controller_Formular_Sjpk_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpk_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjpk_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpk_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjpk_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

            case 'SJPO':
                /** SJPO **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "sjpo_ukonceni_uc":
                        return new Projektor2_Controller_Formular_Sjpo_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "sjpo_zamestnani_uc":
                        return new Projektor2_Controller_Formular_Sjpo_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr routeru form "'.$form.'" v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

            case 'SJLP':
                /** SJLP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
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
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "ukonceni":
                        return (new Projektor2_Controller_Formular_IP2($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "zamestnani":
                        return (new Projektor2_Controller_Formular_Sjlp_Zamestnani($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr routeru form "'.$form.'" v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

            case 'VDTP':
                /** VDTP**/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Vdtp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "smlouva":
                        return new Projektor2_Controller_Formular_Vdtp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "ukonceni":
                        return new Projektor2_Controller_Formular_Vdtp_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

           case 'PDU':
                /** PDU **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Pdu_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                   case "smlouva":
                        return new Projektor2_Controller_Formular_Pdu_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "ukonceni":
                        return new Projektor2_Controller_Formular_Pdu_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr form '.$form.' v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;

            case 'MB':
                /** MB **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return (new Projektor2_Controller_Formular_Mb_Smlouva($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "dotaznik":
                        return new Projektor2_Controller_Formular_Mb_Dotaznik($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "smlouva":
                        return new Projektor2_Controller_Formular_Mb_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "souhlas":
                        return new Projektor2_Controller_Formular_Mb_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "ukonceni":
                        return new Projektor2_Controller_Formular_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zamestnani":
                        return new Projektor2_Controller_Formular_Mb_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException('Router '.get_called_class().' - Neznámý parametr routeru form "'.$form.'" v projektu '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
                }
                break;
            case 'CJC':
                /** CJC **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Cizinec($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "cizinec":
                        return new Projektor2_Controller_Formular_Cizinec($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "smlouva":
                        return new Projektor2_Controller_Formular_Cjc_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "souhlas":
                        return new Projektor2_Controller_Formular_Cjc_Souhlas($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return (new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response))->getResult();
                        break;
                    case "ukonceni":
                        return new Projektor2_Controller_Formular_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zamestnani":
                        return new Projektor2_Controller_Formular_Cjc_Zamestnani($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException("Router ".get_called_class()." - Neznámý parametr předaný routeru '$form' v projektu $kodProjektu.");
                }
                break;

            case 'CKP':
                /** CKP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Ckp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "smlouva":
                        return new Projektor2_Controller_Formular_Ckp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ukonceni":
                        return new Projektor2_Controller_Formular_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException("Router ".get_called_class()." - Neznámý parametr předaný routeru '$form' v projektu $kodProjektu.");
                }
                break;
            case 'PKP':
                /** PKP **/
                switch($form) {
                    case self::CTRL_NOVA_OSOBA:
                        return new Projektor2_Controller_Formular_Pkp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "smlouva":
                        return new Projektor2_Controller_Formular_Pkp_Smlouva($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "plan":
                        return new Projektor2_Controller_Formular_IP1($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ukonceni":
                        return new Projektor2_Controller_Formular_IP2($this->sessionStatus, $this->request, $this->response);
                        break;
                    default:
                        throw new UnexpectedValueException("Router ".get_called_class()." - Neznámý parametr předaný routeru '$form' v projektu $kodProjektu.");
                }
                break;


            default:
                throw new UnexpectedValueException('Neznámý kód projektu: '.$this->sessionStatus->getUserStatus()->getProjekt()->kod);
        }


    }
}

