<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_IP0 extends Projektor2_Controller_Formular_IP {
    

    protected function createFormModels() {
        $this->models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($this->sessionStatus->getUserStatus()->getZajemce()); 
        $this->models['dotaznik'] = new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->getUserStatus()->getZajemce());         
    }
    
    protected function formular() {
        $view = new Projektor2_View_HTML_Formular_IP0($this->sessionStatus, $this->createContextFromModels(TRUE));
        $view->assign('nadpis', 'INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Alternativní práce')
            ->assign('formAction', 'ap_ip1_uc')
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))
            ->assign('submitTiskIP0', array('name'=>'pdf', 'value'=>'Tiskni IP vstupní část'));

        return $view;
    }
    
    protected function getResultPdf() {
        $file = 'IP_cast1';        
        $fileName = $this->createFileName($this->sessionStatus, $file);
        $view = new Projektor2_View_PDF_Ap_IP0($this->sessionStatus, $this->createContextFromModels());  
        $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text)
            ->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name)
            ->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator)
            ->assign('znacka', $this->sessionStatus->getUserStatus()->getZajemce()->znacka)
            ->assign('file', $fileName)
            ->assign('projekt', $this->sessionStatus->projekt)
                    ;    
        
        $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }
}

?>
