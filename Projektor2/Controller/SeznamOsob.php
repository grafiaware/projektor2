<?php
/**
 * Description of Projektor2_Controller_ZobrazeniRegistraci
 *
 * @author pes2704
 */
class Projektor2_Controller_SeznamOsob extends Projektor2_Controller_Abstract {

    protected function getLeftMenuArray() {
        $menuArray[] = ['href'=>'index.php?osoby=form&form=novy_zajemce&novy_zajemce', 'text'=>'Nová osoba'];
        $menuArray[] = ['href'=>'index.php?osoby=excel', 'text'=>'Exporty dat'];
        $menuArray[] = ['href'=>'index.php?osoby=export_certifikaty_kurz', 'text'=>'Exportuj IP certifikáty'];
        $menuArray[] = ['href'=>'index.php?osoby=export_certifikaty_projekt', 'text'=>'Exportuj projektové certifikáty'];
        return $menuArray;
    }

###################
    public function getResult() {
        $viewLeftMenu = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);
        $gridColumns[] = $viewLeftMenu;

        $behy = Projektor2_Model_Db_BehMapper::find('id_c_projekt='.$this->sessionStatus->projekt->id, 'beh_cislo ASC');
        $row[] = new Projektor2_View_HTML_KontextBeh($this->sessionStatus,
                array('behy'=>$behy,
                    'id_beh'=>isset($this->sessionStatus->beh->id) ? $this->sessionStatus->beh->id : NULL)
                );

        $osobyMenu = Projektor2_Viewmodel_OsobaMenuViewmodelMapper::findInContext(NULL, NULL, "identifikator");
        if ($osobyMenu) {
            $row[] = (string) (new Projektor2_Controller_Element_TabulkaMenuOsoby($this->sessionStatus, $this->request, $this->response, $osobyMenu))->getResult();
        }
        
        $gridColumns[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$row, 'class'=>'content']);
        $viewZobrazeniRegistraci = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$gridColumns, 'class'=>'grid-container']);

        return $viewZobrazeniRegistraci;
    }
}

