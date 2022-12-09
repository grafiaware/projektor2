<?php
/**
 * Description of Projektor2_Controller_Formular_Ap_IP2
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_IP2 extends Projektor2_Controller_Formular_IP {

    protected function createFormModels() {
        $this->models['ukonceni'] = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($this->sessionStatus->zajemce); 
        $this->models['plan']= new Projektor2_Model_Db_Flat_ZaPlanFlatTable($this->sessionStatus->zajemce);
        $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($this->sessionStatus->zajemce);
    }
    
    protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Config_Aktivity::findAktivity($this->sessionStatus->projekt->kod, Config_Aktivity::TYP_KURZ);
        $aktivityProjektuTypuPoradenstvi = Config_Aktivity::findAktivity($this->sessionStatus->projekt->kod, Config_Aktivity::TYP_PORADENSTVI);
        $kurzyModelsAssoc = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);
        $kurzyPlanAssoc = Projektor2_Viewmodel_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->zajemce);
        
        $ukonceniArray = Projektor2_AppContext::getUkonceniProjektu($this->sessionStatus->projekt->kod);
        
        $view = new Projektor2_View_HTML_Formular_IP2($this->sessionStatus, $this->createContextFromModels(TRUE));     
        $view->assign('nadpis', 'UKONČENÍ ÚČASTI V PROJEKTU A DOPLNĚNÍ IP - 2. část')
            ->assign('formAction', 'ap_ukonceni_uc')
            ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)                
            ->assign('aktivityProjektuTypuPoradenstvi', $aktivityProjektuTypuPoradenstvi)                
            ->assign('duvodUkonceniValuesArray', $ukonceniArray['duvod'])
            ->assign('duvodUkonceniHelpArray', $ukonceniArray['duvodHelp'])
            ->assign('s_certifikatem', $ukonceniArray['s_certifikatem'])
            ->assign('kurzyModels', $kurzyModelsAssoc)
            ->assign('aktivityPlan', $kurzyPlanAssoc)                
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))                
            ->assign('submitTiskIP2', array('name'=>'pdf', 'value'=>'Tiskni IP 2.část - vyhodnocení aktivit'))
            ->assign('submitTiskIP2Hodnoceni', array('name'=>'pdf', 'value'=>'Tiskni IP 2.část - doplnění hodnocení'))
            ->assign('submitTiskUkonceni', array('name'=>'pdf', 'value'=>'Tiskni ukončení účasti'));
      
        return $view;
    }
    
    protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 2.část - vyhodnocení aktivit") {
            $kurzyPlan = Projektor2_Viewmodel_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->zajemce);
            $aktivityProjektuTypuPoradenstvi = Config_Aktivity::findAktivity($this->sessionStatus->projekt->kod, Config_Aktivity::TYP_PORADENSTVI);            
            $view = new Projektor2_View_PDF_Ap_IP2($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast2';
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka)
                ->assign('aktivityPlan', $kurzyPlan)
                ->assign('aktivityProjektuTypuPoradenstvi', $aktivityProjektuTypuPoradenstvi);                
//            $this->assignKurzyToPdfView($this->models['plan'], $view);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();            
        }
        
        if ($this->request->post('pdf') == "Tiskni IP 2.část - doplnění hodnocení") {
            $kurzyPlan = Projektor2_Viewmodel_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->zajemce);
            $aktivityProjektuTypuPoradenstvi = Config_Aktivity::findAktivity($this->sessionStatus->projekt->kod, Config_Aktivity::TYP_PORADENSTVI);            
            $view = new Projektor2_View_PDF_Ap_IP2Hodnoceni($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast2';
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka)
                ->assign('aktivityPlan', $kurzyPlan)
                ->assign('aktivityProjektuTypuPoradenstvi', $aktivityProjektuTypuPoradenstvi);                
//            $this->assignKurzyToPdfView($this->models['plan'], $view);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();            
        }
        
        if ($this->request->post('pdf') == "Tiskni ukončení účasti") {
            $view = new Projektor2_View_PDF_Ap_Ukonceni($this->sessionStatus, $this->createContextFromModels());
            $file = 'ukonceni';
            //status proměnné
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka);        
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();            
        }

        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení') === 0 ) {
            $datumCertif = $this->models['ukonceni']->datum_certif;
            $params = array('datumCertif' => $datumCertif);
            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Projekt($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();                      
        }       
        
        return $htmlResult;
    }
    
  
}

?>
