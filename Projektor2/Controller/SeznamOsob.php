<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamOsob extends Projektor2_Controller_Abstract {

    protected function getLeftMenuArray() {
        if ($this->hasBeh()) {
            $menuArray[] = ['href'=>'index.php?akce=osoby&osoby=form&form='.Projektor2_Router_Form::CTRL_NOVA_OSOBA, 'text'=>'Nová osoba'];
        }
        $menuArray[] = ['href'=>'index.php?akce=osoby&osoby=excel', 'text'=>'Exporty dat'];
        $menuArray[] = ['href'=>'index.php?akce=osoby&osoby=export_certifikaty_projekt', 'text'=>'Exportuj projektové certifikáty'];
        return $menuArray;
    }

###################
    public function getResult() {
        $behy = Projektor2_Model_Db_BehMapper::find('id_c_projekt='.$this->sessionStatus->getUserStatus()->getProjekt()->id, 'beh_cislo DESC');
        $row[] = new Projektor2_View_HTML_KontextBeh($this->sessionStatus,
                array('behy'=>$behy,
                    'id_beh'=> $this->hasBeh() ? $this->sessionStatus->getUserStatus()->getBeh()->id : NULL)
                );
        // musí být vybrán běh - jinak je výsledků příliš mnoho, výjimku má sys_admin pro development
        $displayOsoby = true; //$this->hasBeh() || ($this->sessionStatus->getUserStatus()->getUser()->username=="sys_admin");
        if ($displayOsoby) {
//            $osobyMenu = Projektor2_Viewmodel_OsobaMenuViewmodelMapper::findInContext(NULL, NULL, "prijmeni, jmeno"); //"znacka"); //"prijmeni");
//            $osobyMenu = Projektor2_Viewmodel_OsobaMenuViewmodelMapper::findInContext(NULL, NULL, "znacka"); 
            $osobyMenu = Projektor2_Viewmodel_OsobaMenuViewmodelMapper::findInContext(NULL, NULL, "left(znacka, 1), id_zajemce"); 
            if ($osobyMenu) {
                $row[] = (string) (new Projektor2_Controller_Element_TabulkaMenuOsoby($this->sessionStatus, $this->request, $this->response, $osobyMenu))->getResult();
            }
        }

        $gridColumns[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);
        $gridColumns[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$row, 'class'=>'content']);
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$gridColumns, 'class'=>'grid-container']);

        return $viewZobrazeniRegistraci;
    }

    private function hasBeh() {
        return null !== $this->sessionStatus->getUserStatus()->getBeh();
    }
}

