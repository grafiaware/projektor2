<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_ZobrazeniRegistraci extends Projektor2_Controller_Abstract {

    protected function getLeftMenuArray() {

        switch ($this->sessionStatus->projekt->kod) {
            case "NSP":

                break;
            case "PNP":

                break;
            case "SPZP":

                break;
            case "RNH":

                break;
            case "AGP":

                break;
            case "HELP":
                $menuArray = $this->getLeftMenuArrayHelp();
                break;
            case "AP":
                $menuArray = $this->getLeftMenuArrayAp();
                break;
            case "SJZP":
                $menuArray = $this->getLeftMenuArraySjzp();
                break;
            case "VZP":
                $menuArray = $this->getLeftMenuArrayVzp();
                break;
            case "SJPK":
                $menuArray = $this->getLeftMenuArraySjpk();
                break;
             case "ZPM":
                $menuArray = $this->getLeftMenuArrayZpm();
                break;
             case "SPP":
                $menuArray = $this->getLeftMenuArraySpp();
                break;
            case "RP":
                $menuArray = $this->getLeftMenuArrayRp();
                break;
            case "SJPO":
                $menuArray = $this->getLeftMenuArraySjpo();
                 break;
            case "SJLP":
                $menuArray = $this->getLeftMenuArraySjlp();
                break;
             case "VDTP":
                $menuArray = $this->getLeftMenuArrayVdtp();
                break;
            case "PDU":
                $menuArray = $this->getLeftMenuArrayPdu();
                break;
            case "MB":
                $menuArray = $this->getLeftMenuArrayMb();
                break;

            default:
                break;
        }
        return $menuArray;
    }

    private function getLeftMenuArrayAp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=ap_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "ap_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
            $menuArray[] = array('href'=>'index.php?akce=ap_ip_certifikaty_export', 'text'=>'Exportuj IP certifik??ty');
            $menuArray[] = array('href'=>'index.php?akce=ap_projekt_certifikaty_export', 'text'=>'Exportuj projektov?? certifik??ty');
        }
        return $menuArray;
    }

    private function getLeftMenuArrayHelp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=he_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "help_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjzp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=sjzp_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "sjzp_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayVzp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=vzp_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "vzp_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }
    protected function getLeftMenuArrayZpm() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=zpm_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "zpm_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }
    protected function getLeftMenuArraySpp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=spp_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "spp_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }
    protected function getLeftMenuArrayRp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=rp_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "rp_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjpk() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=sjpk_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "sp_manager" OR $this->sessionStatus->user->username == "sp_monitor")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjpo() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=sjpo_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "so_manager" OR $this->sessionStatus->user->username == "so_monitor")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjlp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=sjlp_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "so_manager" OR $this->sessionStatus->user->username == "so_monitor")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayVdtp() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=vdtp_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "vdtp_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayPdu() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=pdu_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "pdu_manager")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayMb() {
        $menuArray[] = array('href'=>'index.php?akce=form&form=mb_novy_zajemce', 'text'=>'Nov?? osoba');
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "mb_manager" OR $this->sessionStatus->user->username == "mb_monitor")) {
            $menuArray[] = array('href'=>'index.php?akce=export', 'text'=>'Exportuj p??ehled');
        }
        return $menuArray;
    }

###################
    public function getResult() {
        $this->sessionStatus->setZajemce();  //smaz??n?? zajemce v session
        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, array('menuArray'=>$this->getLeftMenuArray()));
        $parts[] = $viewLeftMenu;

        $zajemciOsobniUdaje = Projektor2_Model_ZajemceOsobniUdajeMapper::findAll(NULL, NULL, "identifikator");
        if ($zajemciOsobniUdaje) {
            foreach ($zajemciOsobniUdaje as $zajemceOsobniUdaje) {
                $params = array('zajemceOsobniUdaje' => $zajemceOsobniUdaje);
                $tlacitkaController = new Projektor2_Controller_Element_MenuFormulare($this->sessionStatus, $this->request, $this->response, $params);
                $rows[] = $tlacitkaController->getResult();
            }
            $viewZaznamy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, array('rows'=>$rows, 'class'=>'zaznamy'));
            $viewContent = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>array($viewZaznamy), 'class'=>'content'));
            $parts[] = $viewContent;
        }
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts));
        return $viewZobrazeniRegistraci;
    }
}

