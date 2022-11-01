<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamRegistraci extends Projektor2_Controller_Abstract {

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
            case "CJC":
            case "CKP":
            case "PKP":
                $menuArray = $this->getLeftMenuArrayNew();
                break;

            default:
                break;
        }
        return $menuArray;
    }

    private function getLeftMenuArrayAp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=ap_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "ap_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
            $menuArray[] = ['href'=>'index.php?osoby=certifikaty_export', 'text'=>'Exportuj IP certifikáty'];
            $menuArray[] = ['href'=>'index.php?osoby=ap_projekt_certifikaty_export', 'text'=>'Exportuj projektové certifikáty'];
        }
        return $menuArray;
    }

    private function getLeftMenuArrayHelp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=he_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "help_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjzp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=sjzp_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "sjzp_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayVzp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=vzp_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "vzp_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }
    protected function getLeftMenuArrayZpm() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=zpm_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "zpm_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }
    protected function getLeftMenuArraySpp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=spp_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "spp_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }
    protected function getLeftMenuArrayRp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=rp_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "rp_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjpk() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=sjpk_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "sp_manager" OR $this->sessionStatus->user->username == "sp_monitor")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjpo() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=sjpo_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "so_manager" OR $this->sessionStatus->user->username == "so_monitor")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArraySjlp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=sjlp_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "so_manager" OR $this->sessionStatus->user->username == "so_monitor")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayVdtp() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=vdtp_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "vdtp_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayPdu() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=pdu_novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        if ( ($this->sessionStatus->user->username == "sys_admin" OR $this->sessionStatus->user->username == "pdu_manager")) {
            $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exportuj přehled'];
        }
        return $menuArray;
    }

    protected function getLeftMenuArrayNew() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        $menuArray[] = ['href'=>'index.php?osoby=export', 'text'=>'Exporty dat'];
        $menuArray[] = ['href'=>'index.php?osoby=certifikaty_export', 'text'=>'Exportuj IP certifikáty'];
        return $menuArray;
    }
###################
    public function getResult() {
        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);
        $parts[] = $viewLeftMenu;

        $zajemciRegistrace = Projektor2_Viewmodel_ZajemceRegistraceMapper::findAll(NULL, NULL, "identifikator");
        if ($zajemciRegistrace) {
            foreach ($zajemciRegistrace as $zajemceRegistrace) {
                $tlacitkaController = new Projektor2_Controller_Element_MenuZajemce($this->sessionStatus, $this->request, $this->response, $zajemceRegistrace);
                $rows[] = $tlacitkaController->getResult();
            }
            $viewZaznamy = new Projektor2_View_HTML_Element_Table($this->sessionStatus, ['rows'=>$rows, 'class'=>'zaznamy']);
            $viewContent = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$viewZaznamy, 'class'=>'content']);
            $parts[] = $viewContent;
        }

        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$parts, 'class'=>'grid-container']);
        return $viewZobrazeniRegistraci;
    }
}

